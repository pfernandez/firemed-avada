<?php
// Template Name: Join

get_header(); ?>
  <div id="content" class="full-width">
    <?php
      $level = isset($_POST['s2member_pro_paypal_checkout']['membership']) ? $_POST['s2member_pro_paypal_checkout']['membership'] : 1;
      $level = $level % 2 ? 1 : 2;

      echo do_shortcode('[s2Member-Pro-PayPal-Form
        level="'.$level.'"
        ccaps=""
        desc="FireMed"
        ps="paypal"
        lc=""
        cc="USD"
        dg="0"
        ns="1"
        custom="'.c_ws_plugin__s2member_utils_strings::esc_ds(format_to_edit($_SERVER['HTTP_HOST'])).'"
        ta="0"
        tp="0"
        tt="D"
        ra="62.00"
        rp="1"
        rt="Y"
        rr="1"
        rrt=""
        rra="2"
        accept="mastercard,visa,amex,discover"
        accept_via_paypal=""
        coupon=""
        accept_coupons="1"
        default_country_code="US"
        captcha="0"
        success="/signup-thank-you"
      /]');
    ?>
  </div>
<?php

//This is the documented preferred method for adding scripts
//to wordpress; however the domain is being stripped out for some reason
//wp_enqueue_script('jquerytools', 'cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js', array( 'jquery' ), '1.2.7', true);

get_footer(); ?>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="//cdn.jquerytools.org/1.2.7/full/jquery.tools.min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/underscore.js/1.4.4/underscore-min.js"></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/backbone.js/1.0.0/backbone-min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/backbone.extension-min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.serializeObject-min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.scrollTo.min.js"></script>

<?php
/*
// Local unminified libs, for dev testing only
// punch me in the ear, please, if I forget to comment these out
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery-1.9.1.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/underscore.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/backbone.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/backbone.extension-min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.serializeObject-min.js"></script>
<script type="text/javascript" src="<?php bloginfo('template_directory'); ?>/js/jquery.scrollTo.min.js"></script>
*/
?>
<script>

  var JoinFormApp = (function() {

    // Membership levels
    var STUDENT = 1;
    var STUDENT_PLUS = 2;
    var HOUSEHOLD = 3;
    var HOUSEHOLD_PLUS = 4;

    // Form Steps
    var FORM_MEMBERSHIP = 1;
    var FORM_PROMO = 2;
    var FORM_ADDRESS = 3;
    var FORM_PAYMENT = 4;

    var App = Backbone.View.extend();

    // Holds all form data
    App.FormModel = Backbone.Model.extend({
      // Need defined properties to render summary
      defaults: {
        cost: 0,
        discount: 0,
        first_name: [],
        last_name: [],
        custom_fields: {
          family_members: []
        }
      },

      initialize: function() {
        // prevent invalid discount/cost
        this.on("change:discount", function() {
          this.normalizeCurrencyAttr("discount");
        }, this);

        this.on("change:cost", function() {
          this.normalizeCurrencyAttr("cost");
        }, this);
      },

      normalizeCurrencyAttr: function(attr) {
        var number;
        if(!_.isString(attr) || _.isUndefined(this.get(attr))) {
          throw new Error("Invalid argument: Cannot normalize " + attr + " as currency");
        }

        number = this.get(attr);

        // Set empty string to 0
        if(_.isString(number) && $.trim(number) == "") {
          number = 0;
        }

        // Convert string to number
        number = parseFloat(number);

        if(number < 0) {
          throw new Error("Invalid argument: Cannot set currency as a negative number");
        }

        this.set(attr, number);
      },

      getMembershipLevel: function() {
        return parseInt(this.get("membership"));
      },

      set: function(attributes, options) {
        var currentAttributes = _.clone(this.attributes);      // Prevent direct access to this.attr by reference

        if(_.isUndefined(attributes)) { throw new Error("Invalid argument: Missing attributes argument")}

        // Backbone is not handling our deep-nested attributes well
        // So when I try to set "formModel.s2member_pro_paypal_checkout.level",
        // my model is overwriting the entire "s2member_pro_paypal_checkout" object
        //
        // We're going to resolve this by extending our model with the new data first, ourselves
        // So we can handle the deep-level attributes upfront
        // It's probably a little resource intensive to do this every time
        // But it's an effective solution to the problem.
        if(_.isObject(attributes)) {
          attributes = $.extend(true, {}, currentAttributes, attributes);    // First argument is for deep-extend
        }

        // Then pass the entire set of attributes to our parent method
        // And let Backbone do the heavy lifting
        return Backbone.Model.prototype.set.apply(this, [attributes, options]);
      },

      // updates model data from form
      update: function(formView) {
        // To be cleaner, just add data from s2member_pro_paypal_checkout object
        this.set(formView.serializeObject().s2member_pro_paypal_checkout);
      },

      // As though mainstream liberal hasn't done enough...
      destroyFamilies: function() {
        // Oy, this is going to take a little hacking
        // to get around the deep model.
        var attributes = _.clone(this.attributes);
        attributes.first_name = [];
        attributes.last_name = [];
        attributes.custom_fields.member_dob = [];
        attributes.custom_fields.middle_initial = [];
      }
    });
    App.formModel = new App.FormModel();


    /**
     * Base class for all subforms
     */
    App.SubForm = Backbone.View.extend({
      step: -1,

      errorClass: 'reqError',

      // Common elements of all subforms
      baseUI: {
        contentRegion: '.pane',
        openBtn: '.pane-title',
        requiredInputs: 'input[required="required"], select[required="required"]',
        formFields: 'input[type!=submit], select, textarea'
      },

      baseEvents: {
        'click.base openBtn': 'show',
        'change.base formFields': 'handleChange'
      },

      _configure: function() {
        Backbone.View.prototype._configure.apply(this, arguments);

        // Extend with base UI
        this.ui || (this.ui = {});
        this.ui = _.extend({}, this.baseUI, this.ui);

        // Extend with base events
        this.events || (this.events = {});
        this.events = _.extend({}, this.baseEvents, this.events);

        this.addInitializer(function(options) {
          // So any method called from this init has access
          // See backbone.ext TODOs on github ("Fix addInitializer stacking")
          this.bindUIElements();

          // Bring options into object
          _.extend(this, options);
        });
      },

      // Overwrite this method to customize
      // subform's validator config
      // But make sure to define this.validator
      // and initialize jquery tools validator.
      // Note that this will not validate dynamically
      // created fields, so you'll want to call this every
      // time you validate.
      configureValidator: function() {
        this.ui.formFields.validator({
          errorClass: 'reqError',
          message: ''
        });

        this.validator = this.ui.formFields.data("validator");
      },

    show: function(ops) {
      var self = this;
      var o = $.extend({},{
          scrollTo: true,
          scrollTarget: self.$el.offset().top - 150
        }, ops);

        // note: the delay is because I'm sick of dealing with $.slideDown
        // cutting up my elements. Gives time to load full height
        this.ui.contentRegion.stop().delay(200).slideDown(150, function() {
          if (o.scrollTo) {
            $.scrollTo(o.scrollTarget, 300, { easing: 'linear' });
          }
        });
      },

      hide: function() {
        this.ui.contentRegion.hide();
      },

      renderErrors: function(errors) {
        _.each(errors, function(error) {
          error.el.addClass(this.errorClass);
        }, this);
      },

      // Something we all need to learn how to do...
      handleChange: function(evt) {
        if(!(evt instanceof $.Event)) { throw new Error("Change comes in response to big events. What you gave me you couldn't even call an event."); }

        // Remove errors
        $(evt.currentTarget).removeClass(this.errorClass);
      },

      clearErrors: function() {
        this.ui.formFields.removeClass(this.errorClass);
      },


      // Check out h5validate for something more robust
      validate: function() {
        this.configureValidator();
        return this.validator.checkValidity();
      },

      isEmptyForm: function() {
        var isEmpty = true;
        this.ui.formFields.filter("[type!=hidden][type!=submit][type!=button]").each(function() {
          var type = $(this).attr('type');
          if($(this).is("[type=radio], [type=checkbox]")) {
            if($(this).prop("checked")) {
              isEmpty = false;
            }
          }
          else if($.trim($(this).val()) !== "") {
            isEmpty = false;
          }
        });

        return isEmpty;
      }
    });


    /**
     * STEP 1: Membership Type
     * -----------------------
     */


    /**
     * Represents a single membership type button
     */
    App.MembershipTypeSelector = Backbone.View.extend({

      ui: {
        // Hidden form selector
        formSelector: 'input[name="s2member_pro_paypal_checkout[membership]"]'
      },

      events: {
        'click': 'selectType'
      },

      getCost: function() {
        return this.ui.formSelector.data('cost');
      },

      getType: function() {
        return this.ui.formSelector.val();
      },

      getName: function() {
        return this.ui.formSelector.data('name');
      },

      selectType: function() {
        this.ui.formSelector.prop("checked", true);

        Backbone.trigger("form:membershipType:selected", this);
      }
    });

    App.MembershipTypeForm = App.SubForm.extend({
      el: $('#step1'),

      memberTypeChildren: [],

      ui: {
        memberTypeBtn: '.memberOption',
        formSelectors: 'input[name="s2member_pro_paypal_checkout[membership]"]'
      },

      globalEvents: {
        "form:membershipType:selected": "handleSelected"
      },

      initialize: function() {
        var self = this;

        // Create a MembershipTypeSelector view for each button
        this.ui.memberTypeBtn.each(function() {
          var view = new App.MembershipTypeSelector({
            el: $(this)
          });

          self.memberTypeChildren.push(view);
        });
      },

      handleSelected: function(selectedType) {
        // Validate, and let everyone else know we're done here
        if(this.validate()) {
          App.formModel.update(this.ui.formSelectors);
          App.formModel.set({
            cost: selectedType.getCost(),
            typeName: selectedType.getName()
          });

          // Set active class
          this.ui.memberTypeBtn.removeClass('active');
          selectedType.$el.addClass('active');

          // Mark view as complete (used for opacity overlay)
          this.$el.addClass('complete');

          Backbone.trigger("form:subform:complete", this.step);
        }
      },

      validate: function() {
        return (this.ui.formSelectors.filter(":checked").length === 1);
      }
    });


    /**
     * STEP 2: Promo Code
     * -----------------------
     */


    App.PromoForm = App.SubForm.extend({
      el: $('#step2'),

      ui: {
        'codeInput': '#s2member-pro-paypal-checkout-coupon',
        'discountInput': 'input[name*=discount]',
        'discountDisplay': '.form-response',
        'submitBtn': '.continueBtn'
      },

      events: {
        'change codeInput': 'handleCodeInput',
        'click submitBtn': 'handleSubmit'
      },

      initialize: function() {
        // Submit promo code, if we load with a value
        if($.trim(this.ui.codeInput.val()) !== "") {
          this.handleSubmit();
        }
      },

      // Do something here!
      // to check that the promo code
      // is valid, etc.
      // and show errors
      validate: function() {
        var membershipLevel = App.formModel.getMembershipLevel();
        var s2mAttr = App.formModel.get("attr");
        var code = this.ui.codeInput.val();
        var validCode = false;

        // Only validate if code entered
        if($.trim(code) === "") {
          validCode = true;
        }
        else {
          // To make this really easy,
          // We're just going to run a sync ajax call (or... a JAX call, to be technical)
          // to validate code.
          // jQuery tools does not support remote validation.
          //
          // A more robust option would be to wrap jQuery tools
          // inside some promise/deferred-based validator
          // like: http://net.tutsplus.com/tutorials/javascript-ajax/promise-based-validation/
          $.ajax({
            type: "POST",
            url: '<?php echo admin_url('admin-ajax.php'); ?>',
            async: false,
            data: {
              coupon: code,
              membershipLevel: membershipLevel,
              s2mAttr: s2mAttr,
              action: 'apply_promo_code'
            },
            context: this,
            dataType: 'json',
            success: function(res) {
              this.setDiscount(res.discount);
              validCode = true;
            },
            error: function() {
              this.setDiscount(0);
            }
          });
        }

        // Also run standard validator, just for good measure
        return App.SubForm.prototype.validate.apply(this, arguments) && validCode;
      },

      showInvalidCodeError: function() {
        this.ui.discountDisplay.html("<strong>Invalid code</strong>").show();
      },

      setDiscount: function(val) {
        var floatVal = parseFloat(val);
        if(_.isNaN(floatVal) || floatVal < 0) { throw new Error("Cannot set discount: value must be a positive number"); }

        this.ui.discountInput.val(floatVal);
      },

      getDiscount: function() {
        return this.ui.discountInput.val();
      },

      hideDiscount: function() {
        this.ui.discountDisplay.hide();
      },

      showDiscount: function() {
        var text = '<span class="icons-check"></span>';
        this.ui.discountDisplay.html(text).show();
      },

      handleCodeInput: function() {
        // Remove discount
        this.setDiscount(0);
        this.hideDiscount();

        // Submit on change
        this.ui.submitBtn.trigger('click');
      },

      handleSubmit: function() {
        var self = this;

        if(this.validate()) {
          App.formModel.update(this.ui.codeInput.add(this.ui.discountInput));

          // show discount
          if(parseFloat(this.getDiscount()) > 0) {
            this.showDiscount();

            // Give 'em a minute to enjoy their earnings
            window.setTimeout(function() {
              Backbone.trigger("form:subform:complete", self.step);
            }, 200);

            return;
          }

          // Keep on moving
          Backbone.trigger("form:subform:complete", this.step);
        }
        else {
          this.showInvalidCodeError();
        }
      }
    });


    /**
     * STEP 3: Address and Familly
     * -----------------------
     */



    // Sigle family member form row
    App.FamilyMemberView = Backbone.View.extend({

      template: $('#template-familyMemberRow').html(),
      id: 0,

      ui: {
        fields: 'input[type=text]'
      },

      render: function() {
        var html = _.template(this.template, { id: this.id });
        this.$el.html(html);
        this.bindUIElements();

        return this;
      },

      isEmptyForm: function() {
        var isEmpty = true;
        this.ui.fields.each(function() {
          if($.trim($(this).val()) !== "") {
            isEmpty = false;
          }
        });

        return isEmpty;
      },

      close: function() {
        this.undelegateEvents();
        this.$el.remove();
      }
    });


    App.AddressForm = App.SubForm.extend({
      el: $('#step3'),

      ui: {
        useSameAddress: '#mailing-same-as-home',

        street_mail: '#mailing-address-street',
        city_mail: '#mailing-address-city',
        state_mail: '#mailing-address-state',
        zip_mail: '#mailing-address-zip',

        street_home: '#home-address-street',
        city_home: '#home-address-city',
        state_home: '#home-address-state',
        zip_home: '#home-address-zip',

        familyMemberRow: '.member',
        familyMemberRowsRegion: '#familyMemberRowsRegion',    // Wrapper around rows
        familyFormSection: '#family-section',                 // The entire form, surrounding text, etc
        addFamilyMemberBtn: '#add-family-member',

        submitBtn: '.continueBtn'
      },

      // map mailing to home address fields
      // for easy transfer
      mailHomeUIMap: {
        'street_mail': 'street_home',
        'city_mail': 'city_home',
        'state_mail': 'state_home',
        'zip_mail': 'zip_home'
      },

      mailUI: [
        'street_mail',
        'city_mail',
        'state_mail',
        'zip_mail'
      ],

      familyMemberLimit: 19,
      familyMemberRows: '#familyMemberRowsRegion .member',
      familyMemberChildren: [],       // child views

      events: {
        'change useSameAddress': 'handleUseSameAddress',
        'click submitBtn': 'handleSubmit',
        'click addFamilyMemberBtn': 'addFamilyMember',

        // Uncheck "copy" box, if changes occur
        'change homeFields': 'handleUseSameAddress'
      },

      initialize: function() {
        // Add the first member row
        this.openFamilyForm();

        // Combine mail and home fields
        // Note: uiBindings are the original selectors (not $ objects)
        this.uiBindings.mailFields = [
          this.uiBindings.street_mail,
          this.uiBindings.city_mail,
          this.uiBindings.state_mail,
          this.uiBindings.zip_mail
        ].join(", ");

        this.uiBindings.homeFields = [
          this.uiBindings.street_home,
          this.uiBindings.city_home,
          this.uiBindings.state_home,
          this.uiBindings.zip_home
        ].join(", ");

        // Delegate events for these new UIs
        this.bindUIElements();
        this.delegateEvents();
      },

      addFamilyMember: function() {
        if (this.familyMemberLimit <= $(this.familyMemberRows).length) {
          return false;
        }

        // We're assuming we start out with a row in the
        // DOM that we can clone
        var formView = new App.FamilyMemberView();

        formView.id = $(this.familyMemberRows).length + 1;

        formView.render().$el.appendTo(this.ui.familyMemberRowsRegion);

        // Update UI elements, to include new row
        this.bindUIElements();

        // Save view controller for future reference
        this.familyMemberChildren.push(formView);

        return false;
      },

      closeChild: function(view) {
        var viewIndex;
        if(!(view instanceof Backbone.View)) { throw new Error("Invalid argument: view must be a Backbone View"); }

        viewIndex = _.indexOf(this.familyMemberChildren, view);
        view.close();
        this.familyMemberChildren.splice(viewIndex, 1);
      },

      // Removes all family member rows
      // And hides the form
      closeFamilyForm: function() {
        _.each(this.familyMemberChildren, this.closeChild);
        this.ui.familyFormSection.hide();

        // Remove family data from model
        // I wish this data-view binding was better stuctured
        // But it's a little funky with all the deep-nesting
        // And the way the s2member data is structured.
        // In a perfect world, there would be a family member model
        // Which could synchronize with the form model
        App.formModel.destroyFamilies();

        this.bindUIElements();
      },

      openFamilyForm: function() {
        this.ui.familyFormSection.show();
      },

      // Note: will always keep at least one row
      removeEmptyFamilyMemberRows: function() {
        var emptyViews = [];

        // Identify empty views
        for(var i = this.familyMemberChildren.length - 1; i > -1; i--) {
          var view = this.familyMemberChildren[i];
          if(view.isEmptyForm()) {
            emptyViews.push(view);
          }
        }

        // Remove empty vies
        _.each(emptyViews, this.closeChild);

        // Update this.ui
        this.bindUIElements();
      },

      copyMailToHome: function() {
        for(var mail in this.mailHomeUIMap) {
          var $mail = this.ui[mail];
          var $home = this.ui[this.mailHomeUIMap[mail]];

          $mail.val($home.val());
          $mail.trigger('change');
        }
      },

      handleUseSameAddress: function(evt) {
        if(this.ui.useSameAddress.is(":checked")) {
          this.copyMailToHome();
        }
      },

      handleSubmit: function() {
        this.removeEmptyFamilyMemberRows();

        if(this.validate()) {
          App.formModel.update(this.ui.formFields);
          Backbone.trigger("form:subform:complete", this.step);
        }

        return false;
      }

    });


    /**
     * STEP 4: Payment
     * -----------------------
     */


    App.PaymentForm = App.SubForm.extend({
      el: $('#step4'),

      template: '#template-orderSummary',

      ui: {
        summaryRegion: '#order-summary',
        creditCards: '#card-type li',
        creditCard: '#card-type li input',
        creditCardsParent: '#card-type',
        submitBtn: '#checkout-submit'
      },

      events: {
        'click creditCards': 'handleCardClick',
        'click submitBtn': 'handleSubmit'
      },

      initialize: function() {
        // Bind form model data to view
        // So order summary will always stay updated
        this.listenTo(App.formModel, "all", this.renderSummary);
      },

      handleCardClick: function(evt) {
        var $input = $(evt.currentTarget).find('input[name="s2member_pro_paypal_checkout[card_type]"]');

        // Bind to hidden form field
        $input.prop("checked", true);

        // Show active
        this.ui.creditCards.removeClass('active');
        $input.parents('li').addClass('active');

        // Remove error class
        this.ui.creditCards.removeClass(this.errorClass);
        this.ui.creditCardsParent.removeClass(this.errorClass);
      },

      renderErrors: function(errors) {
        // Some hackish rendering of cc type error
        // Someday, we'll use a real client-side validation framework on this form...
        var $ccTypeFields = this.ui.creditCards.find("input");
        var self = this;

        // Add error class, if no ccs are checked
        this.ui.creditCards.addClass(this.errorClass);
        this.ui.creditCardsParent.addClass(this.errorClass);
        $ccTypeFields.each(function() {
          if($(this).prop("checked")) {
            self.ui.creditCards.removeClass(self.errorClass);
            self.ui.creditCardsParent.removeClass(self.errorClass);
          }
        });
        App.SubForm.prototype.renderErrors.apply(this, arguments);
      },

      clearErrors: function() {
        this.ui.creditCards.removeClass(this.errorClass);
        App.SubForm.prototype.clearErrors.apply(this, arguments);
      },

      handleSubmit: function(evt) {
        if(!this.validate()) {
          if($(this.ui.creditCard[0]).hasClass(this.errorClass)) {
            this.ui.creditCardsParent.addClass(this.errorClass);
          }
          return false;
        }
      },

      renderSummary: function() {
        var html = _.template($(this.template).html(), { checkout: App.formModel.toJSON() });
        this.ui.summaryRegion.html(html);

        // Update ui bindings
        this.bindUIElements();

        return this;
      },

      show: function() {
        this.renderSummary();

        App.SubForm.prototype.show.apply(this, arguments);
      }
    });


    App.MasterFormController = Backbone.View.extend({
      currentStep: 0,

      // List of subform controllers, by step
      // These will be converted to actual instances
      subFormControllers: {
        1: App.MembershipTypeForm,
        2: App.PromoForm,
        3: App.AddressForm,
        4: App.PaymentForm
      },

      globalEvents: {
        "form:subform:complete": "handleFormComplete"
      },

      events: {
        'submit': 'handleSubmit'
      },

      initialize: function() {
        this.bindFormControllers();
        this.openFormStep(1);
      },

      bindFormControllers: function() {
        // Save, if ever needed
        this.subFormControllerBindings = this.subFormControllers;

        for(var step in this.subFormControllers) {
          this.subFormControllers[step] = new this.subFormControllers[step]({
            step: parseInt(step)
          });
        }
      },

      openFormStep: function(step, ops) {
        if(!this.subFormControllers[step]) {
          throw new Error("Subform '" + step + "' is not defined");
        }

        var o = $.extend({}, {
          show: {}
        }, ops);

        // Create subform view
        var formView = this.subFormControllers[step];
        formView.show(o.show);

        this.currentStep = Math.max(step, this.currentStep);
      },

      handleFormComplete: function(completedStep) {
        this.openFormStep(completedStep + 1);
      },

      handleSubmit: function(evt) {
        var valid = true;
        var form;
        var firstInvalidForm;

        // Validate all subforms
        for(var step in this.subFormControllers) {
          form = this.subFormControllers[step]
          if(!form.validate()) {
            valid = false;
            firstInvalidForm = firstInvalidForm || form;
          }
        }

        // Prevent submit if invalid
        if(!valid) {
          // Open first invalid form
          this.openFormStep(firstInvalidForm.step);

          evt.preventDefault();
          return false;
        }
      },

      // Opens up any forms that have data
      // already entered
      // And all of the preceding forms
      openFormsWithData: function() {
        var highestOpenForm = 0;

        for(var step in this.subFormControllers) {
          if(!this.subFormControllers[step].isEmptyForm()) {
            highestOpenForm = Math.max(highestOpenForm, step);
          }
        }

        // Open all preceding forms
        for(var step = 1; step <= highestOpenForm; step++) {
          this.openFormStep(step, {show: {scrollTo: false}});
        }
      }
    });

    App.start = function() {
      // Add any existing form data to model
      var $form = $('form#s2member-pro-paypal-checkout-form');
      App.formModel.update($form);

      App.masterForm = new App.MasterFormController({
        el: $('#s2member-pro-paypal-checkout-form')
      });

      App.masterForm.openFormsWithData();
    };

    return App;
  })();

  $(document).ready(function() {
    // Create the dropdown base
    jQuery('<select />').appendTo('.nav-holder');

    // Create default option 'Go to...'
    jQuery('<option />', {
      'selected': 'selected',
      'value'   : '',
      'text'    : 'Go to...'
    }).appendTo('.nav-holder select');

    // Populate dropdown with menu items
    jQuery('.nav-holder a').each(function() {
      var el = jQuery(this);

      if(jQuery(el).parents('.sub-menu .sub-menu').length >= 1) {
        jQuery('<option />', {
          'value'   : el.attr('href'),
          'text'    : '-- ' + el.text()
        }).appendTo('.nav-holder select');
      }
      else if(jQuery(el).parents('.sub-menu').length >= 1) {
        jQuery('<option />', {
          'value'   : el.attr('href'),
          'text'    : '- ' + el.text()
        }).appendTo('.nav-holder select');
      }
      else {
        jQuery('<option />', {
          'value'   : el.attr('href'),
          'text'    : el.text()
        }).appendTo('.nav-holder select');
      }
    });

    jQuery('.nav-holder select').change(function() {
      if(jQuery(this).find('option:selected').val() !== '#') {
        window.location = jQuery(this).find('option:selected').val();
      }
    });

    JoinFormApp.start();
    $('.membershipOptions input:checked').click();
  });
</script>

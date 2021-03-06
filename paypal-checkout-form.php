<?php
if (realpath (__FILE__) === realpath ($_SERVER["SCRIPT_FILENAME"]))
  exit("Do not access this file directly.");
?>

<!-- Templates -->
<script id="template-orderSummary" type="template/html">
  <h2>Order Summary</h2>

  <h3>Household Members:</h3>
  <div class="household-members">
    <!-- User -->
    <div class="name">
      <%=checkout.first_name %> <%=checkout.custom_fields.member_middle_initial %> <%=checkout.last_name %>
      <span class="dob"><%=checkout.custom_fields.member_dob %></span>
    </div>
    
    <!-- Family members -->
    <% for(var i in checkout.custom_fields.family_members) {
        var member = checkout.custom_fields.family_members[i];
    %>
      <div class="name">
        <%=member.first_name %> <%=member.middle_initial %> <%=member.last_name %>
        <span class="dob"><%=member.dob %></span>
      </div>
    <% } %>
  </div>

  <!-- Cost: itemized -->
  <div class="order-meta">
    <div class="selected-membership"><%=checkout.typeName %><span class="membership-rate">$<%=parseFloat(checkout.cost).toFixed(2) %></span></div>
    <% if(parseFloat(checkout.discount) > 0) { %>
      <div class="promo-discount">Promo Code Discount<span class="discount-amount">- $<%=parseFloat(checkout.discount).toFixed(2) %></span></div>
    <% } %>
  </div>

  <!-- Cost: total -->
  <div class="checkout-total">
    <div class="total">Total<span class="amount-due">$<%=(parseFloat(checkout.cost) - parseFloat(checkout.discount)).toFixed(2)%></span></div>
  </div>
</script>

<script id="template-familyMemberRow" type="template/html">
  <div class="member family-member">
    <label class="family-member-first-name">
      <span>First Name</span>
      <input type="text" required="required" maxlength="100" autocomplete="off" name="s2member_pro_paypal_checkout[custom_fields][family_members][<%=id %>][first_name]" class="member-first-name" />
    </label>
    <label class="family-member-middle-initial">
      <span>M. I.</span>
      <input type="text" pattern="[a-zA-Z]" required="required" maxlength="1" autocomplete="off" name="s2member_pro_paypal_checkout[custom_fields][family_members][<%=id %>][middle_initial]" class="member-middle-initial" />
    </label>
    <label class="family-member-last-name">
      <span>Last Name</span>
      <input type="text" required="required" maxlength="100" autocomplete="off" name="s2member_pro_paypal_checkout[custom_fields][family_members][<%=id %>][last_name]" class="member-last-name" />
    </label>
    <label class="family-member-dob">
      <span>Date of Birth</span>
      %%family_dob_fields%%
      <input type="hidden" name="s2member_pro_paypal_checkout[custom_fields][family_members][<%=id %>][dob]" class="member-dob" />
    </label>
    <div style="clear:both;"></div>
  </div>
</script>
<!-- end Templates -->

<form id="s2member-pro-paypal-checkout-form" class="s2member-pro-paypal-form s2member-pro-paypal-checkout-form" method="post" action="%%action%%" novalidate="novalidate">
  <div id="accordion">

    <!-- Step 1 -->
    <div id="step1" class="%%complete_membership_level%%">
      <h1 class="current pane-title">Step 1: Choose your membership type</h1>
      <p>Choose which package you would like, or <a href="/about">learn more</a> about your membership options.</p>
      <div id="step1-pane" class="pane" style="display:block">
        <div class="membershipOptions">
          <div class="one_third">
            <div class="button large fire">UO Student</div>

            <div class="memberOption %%active_student_ambulance%%">
              <div class="icons-ambulance"></div>
              <div class="costWhole">
                <p class="cost"><sup>$</sup>35<sup>per year</sup></p>
                <p class="fireMedName">FireMed</p><!-- end firename -->
                <div class="clearboth"></div>
              </div><!-- end costwhole -->
              <label for="membership-student-ambulance">
                <span class="button">Join</span>
                <input required="required" id="membership-student-ambulance" name="s2member_pro_paypal_checkout[membership]" type="radio" value="1" data-name="Firemed (Student)" data-cost="62" %%check_student_ambulance%% />
              </label>
            </div><!-- end member option -->

            <div class="memberOption %%active_student_ambulance_air%%">
              <div class="icons-ambulance-and-helicopter"></div>
              <div class="costWhole">
                <p class="cost" ><sup>$</sup>80<sup>per year</sup></p>
                <p class="fireMedName">FireMed <span class="fplus">Plus</span></p><!-- end firename -->
                <div class="clearboth"></div>
              </div><!-- end costwhole -->
              <label for="membership-student-ambulance-air">
                <span class="button">Join</span>
                <input required="required" id="membership-student-ambulance-air" name="s2member_pro_paypal_checkout[membership]" type="radio" value="2" data-name="Firemed Plus (Student)" data-cost="107" %%check_student_ambulance_air%% />
              </label>
            </div><!-- end member option -->
          </div>

          <div class="one_third">
            <div class="button large fire">Household</div>

            <div class="memberOption %%active_household_ambulance%%">
              <div class="icons-ambulance"></div>
              <div class="costWhole">
                <p class="cost"><sup>$</sup>62<sup>per year</sup></p>
                <p class="fireMedName">FireMed</p><!-- end firename -->
                <div class="clearboth"></div>
              </div><!-- end costwhole -->
              <label for="membership-household-ambulance">
                <span class="button">Join</span>
                <input required="required" id="membership-household-ambulance" name="s2member_pro_paypal_checkout[membership]" type="radio" value="3" data-name="Firemed (Household)" data-cost="62" %%check_household_ambulance%% />
              </label>
            </div><!-- end member option -->

            <div class="memberOption %%active_household_ambulance_air%%">
              <div class="icons-ambulance-and-helicopter"></div>
              <div class="costWhole">
                <p class="cost"><sup>$</sup>107<sup>per year</sup></p>
                <p class="fireMedName">FireMed <span class="fplus">Plus</span></p><!-- end firename -->
                <div class="clearboth"></div>
              </div><!-- end costwhole -->
              <label for="membership-household-ambulance-air">
                <span class="button">Join</span>
                <input required="required" id="membership-household-ambulance-air" name="s2member_pro_paypal_checkout[membership]" type="radio" value="4" data-name="Firemed Plus (Household)" data-cost="107" %%check_household_ambulance_air%% />
              </label>
            </div><!-- end member option -->
          </div>

          <div class="one_third last">
            <div class="button large fire">Business</div>

            <div class="memberOption">
              <div class="centerFire">
                <span><a href="/job-care/">I want to register<br>my business</a></span>
              </div>
            </div><!-- end member option -->

            <div class="memberOption businessAccount">
              <div class="centerFire">
                <span><a href="#">I want to join FireMed<br>using my company’s<br>existing account</a></span>
              </div>
            </div><!-- end member option -->
            <div style="clear: both"></div>
          </div><!-- end .one_third.last -->
        </div><!-- end .membershipOptions -->
        <div style="clear: both"></div>
      </div><!-- end .pane -->
    </div><!-- end #step1 -->

    <div id="step2">
      <h1 class="pane-title">Step 2: Student or business code</h1>
      <div id="member-code-yes-no">
        <p id="member-code-text">Do you have a discount code provided by your school or employer?</p>
        <input type="button" class="button pane-title" value="Yes">
        <input type="button" class="button continueBtn" value="No">
      </div>
      <div id="step2-pane" class="pane" style="%%membership_level_selected%%">
      <div id="step2-subpane">
        <input type="hidden" name="s2member_pro_paypal_checkout[discount]" value="" />
        <!-- Coupon Code ( this will ONLY be displayed if your Shortcode has this attribute: accept_coupons="1" ). -->
        <label for="s2member-pro-paypal-checkout-coupon" id="s2member-pro-paypal-checkout-form-coupon-label" class="s2member-pro-paypal-form-coupon-label s2member-pro-paypal-checkout-form-coupon-label">
          <span><?php echo _x ("Membership Code", "s2member-front", "s2member"); ?></span>
          <input type="text" maxlength="100" autocomplete="off" name="s2member_pro_paypal_checkout[coupon]" id="s2member-pro-paypal-checkout-coupon" class="s2member-pro-paypal-coupon s2member-pro-paypal-checkout-coupon" value="%%coupon_value%%" tabindex="" />
        </label>
        <div class="form-response alert">%%coupon_response%%</div>
        <div style="clear:both;"></div>
        <input type="button" class="button continueBtn default" value="Continue">
      </div>
      </div><!-- end .pane -->
    </div><!-- end #step2 -->

    <div id="step3">
      <h1 class="pane-title">Step 3: Enter your household's information</h1>
      <div id="step3-pane" class="pane">
        <p>Fill out your address information as well as the information of the people in your household.</p>
        <div id="contact-section" class="form-section">
          <div class="one_half">
            <label for="home-address-street">
              <span>Physical Address (Must be within coverage area.)</span>
              <input required="required" type="text" aria-required="true" name="s2member_pro_paypal_checkout[custom_fields][home_address_street]" id="home-address-street" class="" value="%%home_address_street_value%%" tabindex="" />
            </label>

            <div class="avada-row">
              <label for="home-address-city">
                <span>City</span>
                <input required="required" type="text" aria-required="true" name="s2member_pro_paypal_checkout[custom_fields][home_address_city]" id="home-address-city" class="" value="%%home_address_city_value%%" tabindex="" />
              </label>
              <label for="home-address-state">
                <span>State</span>
                <p>Oregon</p>
                <input required="required" type="hidden" id="home-address-state" name="s2member_pro_paypal_checkout[custom_fields][home_address_state]" value="OR" />
              </label>
              <label for="home-address-zip">
                <span>Zip Code</span>
                <?php //This will be needed at some point in the future and s2member is picky so save this: <input required="required" type="text" aria-required="true" autocomplete="off" name="s2member_pro_paypal_checkout[custom_fields][home_address_zip]" id="home-address-zip" class="" value="%%home_address_zip_value%%" tabindex="" /> ?>
                %%home_address_zip%%
              </label>
            </div>
          </div>

          <div class="one_half last">

            <label for="email">
              <span>Email Address</span>
              <input required="required" type="email" required="required" aria-required="true" data-expected="email" maxlength="100" name="s2member_pro_paypal_checkout[email]" id="email" value="%%email_value%%" tabindex="" />
            </label>

            <label for="phone">
              <span>Phone Number</span>
              <input required="required" type="text" pattern="^([0-9]( |-)?)?(\(?[0-9]{3}\)?|[0-9]{3})( |-)?([0-9]{3}( |-)?[0-9]{4}|[a-zA-Z0-9]{7})$" aria-required="true" name="s2member_pro_paypal_checkout[custom_fields][phone]" id="phone" class="" value="%%phone_value%%" tabindex="" />
            </label>
            
          </div>
          <div style="clear:both;"></div>
        </div><!-- end #contact-section.form-section -->

        <div id="family-section" class="form-section">
          <p>Enter your name and the names of all household members to be covered under this membership.</p>

          <!-- First member = this user. -->
          <div class="member">
            <label>
              <span>First Name</span>
              <input required="required" type="text" aria-required="true" maxlength="100" name="s2member_pro_paypal_checkout[first_name]" class="member-first-name" value="%%first_name_value%%" />
            </label>
            <label>
              <span>M. I.</span>
              <input required="required" type="text" pattern="[a-zA-Z]" aria-required="true" maxlength="1" name="s2member_pro_paypal_checkout[custom_fields][member_middle_initial]" class="member-middle-initial" value="%%member_middle_initial_value%%" />
            </label>
            <label>
              <span>Last Name</span>
              <input required="required" type="text" aria-required="true" maxlength="100" name="s2member_pro_paypal_checkout[last_name]" class="member-last-name" value="%%last_name_value%%"  />
            </label>
            <label id="hoh-dob">
              <span>Date of Birth</span>
              %%member_dob_fields%%
              <input type="hidden" name="s2member_pro_paypal_checkout[custom_fields][member_dob]" id="hoh-dob-input" class="member-dob" />
            </label><label><span class="householdLabel">Head of Household</span></label>
            <div style="clear:both;"></div>
          </div>

          <!-- Other family members, added dynamically
              see script#template-familyMemberRow -->
          <div id="familyMemberRowsRegion" class="family-members">
            %%family_members%%
          </div>
          <div id="add-family-member">
            <a href="#">+ Add Family Member</a>
          </div>
        </div><!-- end #family-section.form-section -->
        <input type="button" class="button continueBtn default" value="Continue">
      </div><!-- end .pane -->
    </div><!-- end #step3 -->

    <div id="step4">
      <h1 class="pane-title">Step 4: Payment Information</h1>
      <div id="step4-pane" class="pane">
        <div class="one_half">

          <div id="billing-address-section" class="form-section">
          
            <label for="billing-same-as-home">
              <input type="checkbox" aria-required="false" name="s2member_pro_paypal_checkout[custom_fields][billing_same_as_home]" id="billing-same-as-home" class="" value="%%billing_same_as_home%%" tabindex="" />
              <span>Check if your billing address is the same as your home address</span>
            </label>
          
            <label for="billing-address-street">
              <span>Billing Address</span>
              <input required="required" type="text" aria-required="true" maxlength="100" name="s2member_pro_paypal_checkout[street]" id="billing-address-street" value="%%street_value%%" tabindex="" />
            </label>
            <div class="avada-row">
              <label for="billing-address-city">
                <span>City</span>
                <input required="required" type="text" aria-required="true" maxlength="100" name="s2member_pro_paypal_checkout[city]" id="billing-address-city" value="%%city_value%%" tabindex="" />
              </label>
              <label for="billing-address-state">
                <span>State</span>
                %%billing_address_state%%
              </label>
              <label for="billing-address-zip">
                <span>Zip Code</span>
                <input required="required" pattern="^\d{5}(?:[-\s]\d{4})?$" type="text" aria-required="true" maxlength="100" name="s2member_pro_paypal_checkout[zip]" id="billing-address-zip" value="%%zip_value%%" tabindex="" />
              </label>
            </div>
            <div id="s2member-pro-paypal-checkout-form-ajax-tax-div" class="s2member-pro-paypal-form-div s2member-pro-paypal-checkout-form-div s2member-pro-paypal-form-ajax-tax-div s2member-pro-paypal-checkout-form-ajax-tax-div">
              <!-- Sales Tax will be displayed here via Ajax; based on state, country, and/or zip code range. -->
            </div>
            <div style="clear:both;"></div>
          </div>

          <!-- Billing Method (Customers can use a Credit/Debit card, or PayPal® w/Express Checkout). -->
          <div id="billing-method-section" class="form-section">
            <label for="billing-method-card-holder">
              <span>Your Name (as it appears on your card)</span>
              <input required="required" type="text" aria-required="true" maxlength="100" autocomplete="off" name="s2member_pro_paypal_checkout[card_holder]" id="billing-method-card-holder" value="%%card_holder_value%%" tabindex="" />
            </label>
            <div>
              <label for="billing-method-card-number">
                <span>Card Number</span>
                <input required="required" type="text" pattern="^(\d{4}[- ]){3}\d{4}|\d{16}$" aria-required="true" maxlength="16" autocomplete="off" name="s2member_pro_paypal_checkout[card_number]" id="billing-method-card-number" value="%%card_number_value%%" tabindex="" />
              </label>
              <label for="billing-method-card-cvv">
                <span>CVV <a href="http://en.wikipedia.org/wiki/Card_security_code" target="_blank" tabindex="-1" rel="external nofollow">?</a></span>
                <input required="required" type="text" pattern="^([0-9]{3,4})$" aria-required="true" maxlength="4" autocomplete="off" name="s2member_pro_paypal_checkout[card_verification]" id="billing-method-card-cvv" value="%%card_verification_value%%" tabindex="" />
              </label>
              <label for="billing-method-card-expiration">
                <span>Exp Date</span>
                %%cc_expiration%%
                <input required="required" type="hidden" name="s2member_pro_paypal_checkout[card_expiration]" id="billing-method-card-expiration" value="%%card_expiration_value%%" tabindex="" />
              </label>
              <div style="clear:both;"></div>
              <div id="card-type" aria-required="true" >
                %%checkout_methods%%
              </div>
            </div>
            <div style="clear:both;"></div>
          </div><!-- end #billing-method-section.form-section -->
        </div><!-- end .one_half -->
        <div class="one_half last">
          <!-- see script#template-orderSummary -->
          <div id="order-summary"></div>
        </div>
        <div style="clear:both;"></div>

        <!-- Checkout Now (this holds the submit button, and also some dynamic hidden input required="required" variables). -->
        <div id="form-submission-section">
          <div id="form-submit">
            %%hidden_inputs%% <!-- Auto-filled by the s2Member software. Do NOT remove this under any circumstance. -->
            <input type="submit" id="checkout-submit" class="button default" value="Confirm &amp; Pay" tabindex="" />
            <!-- Response Section (this is auto-filled after form submission). -->
            <div class="form-response" id="page-bottom-response">%%response%%</div>
          </div>
          <div style="clear:both;"></div>
        </div>
      </div><!-- end .pane -->
    </div><!-- end #step4 -->
  </div><!-- end #accordion -->
</form>

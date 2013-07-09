/**
 * Controller.js
 * A pared down version of a view controller
 * By Edan Schwartz, 2013
 * ...though most components are shamelessly stolen from backbone, backbone.marionette
 * A couple are my own
 *
 * Requires:
 *  John Resig's simple inheritence pattern (included)
 *  Ben Alman's TinyPubSub (included)
 *  Underscore.js
 *  jQuery (would probably work with Zepto, but haven't tested)
 */

// Require dependencies
if (!jQuery || $ !== jQuery) {
  throw new Error("Controller class requires jQuery library");
}
if (!_) {
  throw new Error("Controller requires UnderscoreJS library");
}

/* Simple JavaScript Inheritance
 * By John Resig http://ejohn.org/
 * MIT Licensed.
 * http://ejohn.org/blog/simple-javascript-inheritance/
 */
(function(){
  var initializing = false, fnTest = /xyz/.test(function(){xyz;}) ? /\b_super\b/ : /.*/;
  // The base Class implementation (does nothing)
  this.Class = function(){};

  // Create a new Class that inherits from this class
  Class.extend = function(prop) {
    var _super = this.prototype;

    // Instantiate a base class (but only create the instance,
    // don't run the init constructor)
    initializing = true;
    var prototype = new this();
    initializing = false;

    // Copy the properties over onto the new prototype
    for (var name in prop) {
      // Check if we're overwriting an existing function
      prototype[name] = typeof prop[name] == "function" &&
          typeof _super[name] == "function" && fnTest.test(prop[name]) ?
          (function(name, fn){
            return function() {
              var tmp = this._super;

              // Add a new ._super() method that is the same method
              // but on the super-class
              this._super = _super[name];

              // The method only need to be bound temporarily, so we
              // remove it when we're done executing
              var ret = fn.apply(this, arguments);
              this._super = tmp;

              return ret;
            };
          })(name, prop[name]) :
          prop[name];
    }

    // The dummy class constructor
    function Class() {
      // All construction is actually done in the init method
      if ( !initializing && this.construct )
        this.construct.apply(this, arguments);
    }

    // Populate our constructed prototype object
    Class.prototype = prototype;

    // Enforce the constructor to be what we expect
    Class.prototype.constructor = Class;

    // And make this class extendable
    Class.extend = arguments.callee;

    return Class;
  };
})();

/* jQuery Tiny Pub/Sub - v0.7 - 10/27/2011
 * http://benalman.com/
 * Copyright (c) 2011 "Cowboy" Ben Alman; Licensed MIT, GPL */

(function($) {

  var o = $({});

  $.subscribe = function() {
    o.on.apply(o, arguments);
  };

  $.unsubscribe = function() {
    o.off.apply(o, arguments);
  };

  $.publish = function() {
    o.trigger.apply(o, arguments);
  };

}(jQuery));


var Controller = (function() {'use strict';
  // Helper function to get a value from a [[Backbone]] object as a property
  // or as a function.
  var getValue = function(object, prop) {
    if (!(object && object[prop])) {
      return null;
    }
    return _.isFunction(object[prop]) ? object[prop]() : object[prop];
  };

  var delegateEventSplitter = /^(\S+)\s*(.*)$/;

  // Set unique identifier for class instance
  var _uuid;
  var _setUuid = function() {
    _uuid = _.uniqueId('class_');
  };

  var ThisClass = Class.extend({
    ui : {},
    events : {},

    // Subscribe to global events
    // using $.Event bindings
    // eg:
    //  { 'topic': listener }
    //  $.on('topic', listener);
    //  $.trigger('topic', params);
    globalEvents : {},

    construct : function(options) {
      options || (options = {});

      _.extend(this, options);

      _.bindAll(this);

      _setUuid();

      this.$el = options.$el || this.$el || $('<div></div>');
      this.$el = (this.$el instanceof $) ? this.$el : $(this.$el);

      this.delegateEvents();
      this.delegateGlobalEvents();
      this.bindUIElements();

      if (this.initialize) {
        this.initialize();
      }
    },

    getUuid : function() {
      return _uuid;
    },

    delegateGlobalEvents : function() {
      var topic;
      for (topic in this.globalEvents) {
        if (this.globalEvents.hasOwnProperty(topic)) {
          $.subscribe(topic + "." + this.getUuid(), this[this.globalEvents[topic]]);
        }
      }
    },

    // This method binds the elements specified in the "ui" hash inside the view's code with
    // the associated jQuery selectors.
    bindUIElements : function() {
      if (!this.ui) {
        return;
      }

      var that = this;

      if (!this.uiBindings) {
        // We want to store the ui hash in uiBindings, since afterwards the values in the ui hash
        // will be overridden with jQuery selectors.
        this.uiBindings = this.ui;
      }

      // refreshing the associated selectors since they should point to the newly rendered elements.
      this.ui = {};
      _.each(_.keys(this.uiBindings), function(key) {
        var selector = that.uiBindings[key];
        that.ui[key] = that.$el.find(selector);
      });
    },

    undelegateEvents : function() {
      this.$el.off('.delegateEvents');
      $.unsubscribe('.' + this.getUuid());
    },

    delegateEvents : function(events) {
      events || ( events = this.events);
      if (!(events)) {
        return;
      }

      this.undelegateEvents();
      var key;
      for (key in events) {
        if (events.hasOwnProperty(key)) {
          // Determine callback method
          var method = events[key];
          if (!_.isFunction(method)) {
            method = this[events[key]];
          }
          if (!method) {
            throw new Error('Method "' + events[key] + '" does not exist');
          }

          // Split up selector and event binding
          var match = key.match(delegateEventSplitter);
          var eventName = match[1];

          // Check for named selector
          if (!this.uiBindings) {
            this.uiBindings = this.ui;
          }
          var selector = (this.uiBindings && _.has(this.uiBindings, match[2])) ? this.uiBindings[match[2]] : match[2];

          // Bind the event to the DOM object
          method = _.bind(method, this);
          eventName += '.delegateEvents';

          if (selector === '') {
            this.$el.on(eventName, method);
          } else {
            this.$el.on(eventName, selector, method);
          }
        }
      }
    }
  });
  return ThisClass;
})();


/**
 * Extensions for Backbone.View:
 * - named ui elements (borrowed from BB.Marionette)
 * - bind events using named ui elements
 * - bind global events (eg. Backbone.trigger("some:global:event"))
 * - addInitializer method, to prevent overwriting
 *   initialize method in base class (see Jasmine test for example)
 *
 * Copyright (c)2013 Edan Schwartz
 * github.com/eschwartz/backbone.extension
 * www.edanschwartz.com
 *
 * Distributed under MIT license
 */
(function(e){var t=function(e,t){if(!(e&&e[t])){return null}return _.isFunction(e[t])?e[t]():e[t]};var n=/^(\S+)\s*(.*)$/;var r=_.extend({},e.View.prototype);_.extend(e.View.prototype,{ui:{},globalEvents:{},_configure:function(e){r._configure.apply(this,arguments);_.bindAll(this);this.addInitializer(function(e){this.bindUIElements()})},getEventNamespace:function(){return"delegateEvents"+this.cid},addInitializer:function(e){var t=this;var n=this.initialize||function(){};if(!_.isFunction(e)){throw new Error("First argument passed to `addInitializer` must be a function")}_.bind(e,this);_.bind(this.initialize,this);this.initialize=function(){e.call(t,t.options);n.call(t,t.options)}},delegateGlobalEvents:function(t){var n;var r;t||(t=this.globalEvents);if(!t){return}for(n in t){if(t.hasOwnProperty(n)){var i=this[t[n]];this.listenTo(e,n,i)}}},bindUIElements:function(){if(!this.ui){return}var e=this;if(!this.uiBindings){this.uiBindings=this.ui}this.ui={};_.each(_.keys(this.uiBindings),function(t){var n=e.uiBindings[t];e.ui[t]=e.$el.find(n)})},undelegateEvents:function(){this.stopListening(e);r.undelegateEvents.apply(this,arguments)},delegateEvents:function(e){this.undelegateEvents();this.delegateGlobalEvents();e||(e=this.events);if(!e){return}var t;for(t in e){if(e.hasOwnProperty(t)){var r=e[t];if(!_.isFunction(r)){r=this[e[t]]}if(!r){throw new Error('Method "'+e[t]+'" does not exist')}var i=t.match(n);var s=i[1];if(!this.uiBindings){this.uiBindings=this.ui}var o=this.uiBindings&&_.has(this.uiBindings,i[2])?this.uiBindings[i[2]]:i[2];r=_.bind(r,this);s+="."+this.getEventNamespace();if(o===""){this.$el.on(s,r)}else{this.$el.on(s,o,r)}}}}})})(Backbone)
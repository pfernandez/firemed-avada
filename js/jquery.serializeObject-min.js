// Combination of jQuery.deparam and jQuery.serializeObject by Ben Alman.
/*!
 * jQuery BBQ: Back Button & Query Library - v1.2.1 - 2/17/2010
 * http://benalman.com/projects/jquery-bbq-plugin/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
/*!
 * jQuery serializeObject - v0.2 - 1/20/2010
 * http://benalman.com/projects/jquery-misc-plugins/
 *
 * Copyright (c) 2010 "Cowboy" Ben Alman
 * Dual licensed under the MIT and GPL licenses.
 * http://benalman.com/about/license/
 */
 (function(e){e.fn.serializeObject=function(t){var n={},r={"true":!0,"false":!1,"null":null};e.each(this.serializeArray(),function(i,s){var o=s.name,u=s.value,a=n,f=0,l=o.split("]["),c=l.length-1;if(/\[/.test(l[0])&&/\]$/.test(l[c])){l[c]=l[c].replace(/\]$/,"");l=l.shift().split("[").concat(l);c=l.length-1}else{c=0}if(t){u=u&&!isNaN(u)?+u:u==="undefined"?undefined:r[u]!==undefined?r[u]:u}if(c){for(;f<=c;f++){o=l[f]===""?a.length:l[f];a=a[o]=f<c?a[o]||(l[f+1]&&isNaN(l[f+1])?{}:[]):u}}else{if(e.isArray(n[o])){n[o].push(u)}else if(n[o]!==undefined){n[o]=[n[o],u]}else{n[o]=u}}});return n}})(jQuery)
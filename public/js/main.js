"use strict";jQuery(document).ready(function(e){function o(){return window.getComputedStyle(v.get(0),"::before").getPropertyValue("content").replace(/"/g,"").replace(/'/g,"")}function i(){t||(t=!0,window.requestAnimationFrame?window.requestAnimationFrame(n):setTimeout(n,300))}function n(){var i=o();if("desktop"==i&&0==h.siblings(".cd-main-search").length)l.detach().insertBefore(h),s.detach().insertBefore(l).find(".cd-serch-wrapper").remove();else if("mobile"==i&&0!=v.children(".cd-main-nav-wrapper").length){s.detach().insertAfter(".cd-main-content");var n=e('<li class="cd-serch-wrapper"></li>');l.detach().appendTo(n),n.appendTo(c)}t=!1}function a(){d.removeClass("search-form-visible"),l.removeClass("is-visible"),f.removeClass("search-form-visible")}e.fn.datepicker.defaults.format="dd/mm/yyyy",e.fn.datepicker.defaults.autoclose=!0,e.fn.datepicker.defaults.orientation="right bottom",e(".datepicker").datepicker({startDate:"-3d"});var t=!1,s=e(".cd-main-nav-wrapper"),c=s.children(".cd-main-nav"),l=e(".cd-main-search"),r=e(".cd-main-content"),d=e(".cd-search-trigger"),f=e(".cd-cover-layer"),h=e(".cd-nav-trigger"),v=e(".cd-main-header");!Modernizr.testProp("pointerEvents")&&e("html").addClass("no-pointerevents"),n(),e(window).on("resize",i),h.on("click",function(e){e.preventDefault(),v.add(c).add(r).toggleClass("nav-is-visible")}),d.on("click",function(e){e.preventDefault(),d.hasClass("search-form-visible")?l.find("form").submit():(d.addClass("search-form-visible"),f.addClass("search-form-visible"),l.addClass("is-visible").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend",function(){l.find('input[type="search"]').focus().end().off("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend")}))}),l.on("click",".close",function(){a()}),f.on("click",function(){a()}),e(document).keyup(function(e){"27"==e.which&&a()}),l.on("change","select",function(){l.find(".selected-value").text(e(this).children("option:selected").text())}),e(".star-rating-fn").barrating({theme:"fontawesome-stars",emptyValue:0}),e(".star-rating-ro").barrating({readonly:!0,hoverState:!1,emptyValue:0,theme:"fontawesome-stars"}),e(function(){e('[data-toggle="tooltip"]').tooltip()}),e(".custom-file-input").on("change",function(){e(this).next().after().text(e(this).val().split("\\").slice(-1)[0])}),e(".radio-link.active").find(".custom-control-input").prop("checked",!0),e(".radio-link").click(function(){e(this).find(".custom-control-input").prop("checked",!0)}),e("#first-level > .case-01  > .radio-yes-case").click(function(){e("#second-level > .no-case-info").hide(),e("#third-level > .no-case-info , #third-level > .yes-case-info").hide(),e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(),e("#five-level > .no-case-info , #five-level > .yes-case-info").hide(),e("#second-level > .yes-case-info").show()}),e("#first-level > .case-01 > .radio-no-case").click(function(){e("#second-level > .no-case-info").show(),e("#second-level > .yes-case-info").hide(),e("#third-level > .no-case-info , #third-level > .yes-case-info").hide(),e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(),e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()}),e("#second-level  .case-02  > .radio-yes-case").click(function(){e("#third-level > .no-case-info").hide(),e("#third-level > .yes-case-info").show(),e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(),e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()}),e("#second-level  .case-02 > .radio-no-case").click(function(){e("#third-level > .no-case-info").show(),e("#third-level > .yes-case-info").hide(),e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(),e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()}),e("#third-level  .case-03  > .radio-yes-case").click(function(){e("#four-level > .no-case-info").hide(),e("#four-level > .yes-case-info").show(),e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()}),e("#third-level  .case-03 > .radio-no-case").click(function(){e("#four-level > .no-case-info").show(),e("#four-level > .yes-case-info").hide(),e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()}),e("#four-level  .case-04  > .radio-yes-case").click(function(){e("#five-level > .no-case-info").hide(),e("#five-level > .yes-case-info").show()}),e("#four-level  .case-04 > .radio-no-case").click(function(){e("#five-level > .no-case-info").show(),e("#five-level > .yes-case-info").hide()}),e("body").hasClass("home")&&(window.sr=ScrollReveal({reset:!1}),sr.reveal(".home .here-center h1",{opacity:0,distance:"10rem",duration:2e3,scale:1,origin:"top"}),sr.reveal(".home .here-center p",{opacity:0,duration:2e3,origin:"top"}),sr.reveal(".home .btn-hero",{opacity:0,distance:"10rem",duration:2e3,scale:1,origin:"bottom"}),sr.reveal(".home .img-fluid",{opacity:0,distance:"10rem",duration:2e3,scale:1,origin:"left"}),sr.reveal(".home .arrow-down",{opacity:0,distance:"10rem",duration:1e3,scale:1,origin:"top"}),sr.reveal(".home .featured-block h2, .home .featured-block p, .home .featured-block .btn",{opacity:0,distance:"10rem",duration:1e3,scale:1,origin:"bottom"}),sr.reveal(".home .box-block-into, .home .box-block-into h3, .home .box-block-into p, .home .box-block-into .btn, .home .box-block-into a",{opacity:0,distance:"10rem",duration:2e3,scale:1,origin:"bottom"}),sr.reveal(".home .company-box, .home .footer",{opacity:0,distance:"10rem",duration:1500,scale:1,origin:"bottom"})),e("body").delegate("span[data-replace]","click",function(o){o.preventDefault(),e(this).html(e(this).attr("data-replace"))}),e(document).on("click",'a[href^="#"]',function(o){o.preventDefault(),e("html, body").animate({scrollTop:e(e.attr(this,"href")).offset()},800)})});
"use strict";
jQuery(document).ready(function (e) {
    function i() {
        return window.getComputedStyle(h.get(0), "::before").getPropertyValue("content").replace(/"/g, "").replace(/'/g, "")
    }

    function o() {
        a || (a = !0, window.requestAnimationFrame ? window.requestAnimationFrame(n) : setTimeout(n, 300))
    }

    function n() {
        var o = i();
        if ("desktop" == o && 0 == v.siblings(".cd-main-search").length) t.detach().insertBefore(v), c.detach().insertBefore(t).find(".cd-serch-wrapper").remove();
        else if ("mobile" == o && 0 != h.children(".cd-main-nav-wrapper").length) {
            c.detach().insertAfter(".cd-main-content");
            var n = e('<li class="cd-serch-wrapper"></li>');
            t.detach().appendTo(n), n.appendTo(r)
        }
        a = !1
    }

    function s() {
        d.removeClass("search-form-visible"), t.removeClass("is-visible"), f.removeClass("search-form-visible")
    }
    var a = !1,
        c = e(".cd-main-nav-wrapper"),
        r = c.children(".cd-main-nav"),
        t = e(".cd-main-search"),
        l = e(".cd-main-content"),
        d = e(".cd-search-trigger"),
        f = e(".cd-cover-layer"),
        v = e(".cd-nav-trigger"),
        h = e(".cd-main-header");
    !Modernizr.testProp("pointerEvents") && e("html").addClass("no-pointerevents"), n(), e(window).on("resize", o), v.on("click", function (e) {
        e.preventDefault(), h.add(r).add(l).toggleClass("nav-is-visible")
    }), d.on("click", function (e) {
        e.preventDefault(), d.hasClass("search-form-visible") ? t.find("form").submit() : (d.addClass("search-form-visible"), f.addClass("search-form-visible"), t.addClass("is-visible").one("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend", function () {
            t.find('input[type="search"]').focus().end().off("webkitTransitionEnd otransitionend oTransitionEnd msTransitionEnd transitionend")
        }))
    }), t.on("click", ".close", function () {
        s()
    }), f.on("click", function () {
        s()
    }), e(document).keyup(function (e) {
        "27" == e.which && s()
    }), t.on("change", "select", function () {
        t.find(".selected-value").text(e(this).children("option:selected").text())
    }), e(".star-rating-fn").barrating({
        theme: "fontawesome-stars"
    }), e(".star-rating-ro").barrating({
        readonly: !0,
        hoverState: !1,
        theme: "fontawesome-stars"
    }), e(".custom-file-input").on("change", function () {
        e(this).next().after().text(e(this).val().split("\\").slice(-1)[0])
    }), e(".radio-link.active").find(".custom-control-input").prop("checked", !0), e(".radio-link").click(function () {
        e(this).find(".custom-control-input").prop("checked", !0)
    }), e("#first-level > .case-01  > .radio-yes-case").click(function () {
        e("#second-level > .no-case-info").hide(), e("#third-level > .no-case-info , #third-level > .yes-case-info").hide(), e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(), e("#five-level > .no-case-info , #five-level > .yes-case-info").hide(), e("#second-level > .yes-case-info").show()
    }), e("#first-level > .case-01 > .radio-no-case").click(function () {
        e("#second-level > .no-case-info").show(), e("#second-level > .yes-case-info").hide(), e("#third-level > .no-case-info , #third-level > .yes-case-info").hide(), e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(), e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()
    }), e("#second-level  .case-02  > .radio-yes-case").click(function () {
        e("#third-level > .no-case-info").hide(), e("#third-level > .yes-case-info").show(), e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(), e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()
    }), e("#second-level  .case-02 > .radio-no-case").click(function () {
        e("#third-level > .no-case-info").show(), e("#third-level > .yes-case-info").hide(), e("#four-level > .no-case-info , #four-level > .yes-case-info").hide(), e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()
    }), e("#third-level  .case-03  > .radio-yes-case").click(function () {
        e("#four-level > .no-case-info").hide(), e("#four-level > .yes-case-info").show(), e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()
    }), e("#third-level  .case-03 > select").change(function () {
    	if(e(this).val() == 'other') {
        	e("#four-level > .no-case-info").show(), e("#four-level > .yes-case-info").hide(), e("#five-level > .no-case-info , #five-level > .yes-case-info").hide()
    	}else {
    		e("#four-level > .no-case-info").hide()
    	}
    }), e("#four-level  .case-04  > .radio-yes-case").click(function () {
        e("#five-level > .no-case-info").hide(), e("#five-level > .yes-case-info").show()
    }), e("#four-level  .case-04 > .radio-no-case").click(function () {
        e("#five-level > .no-case-info").show(), e("#five-level > .yes-case-info").hide()
    }), e("body").hasClass("home") && (window.sr = ScrollReveal({
        reset: !0
    }), sr.reveal(".home .hero h1", {
        opacity: 0,
        distance: "10rem",
        duration: 2e3,
        scale: 1,
        origin: "top"
    }), sr.reveal(".home .hero p", {
        opacity: 0,
        duration: 2e3,
        origin: "top"
    }), sr.reveal(".home .btn-hero", {
        opacity: 0,
        distance: "10rem",
        duration: 2e3,
        scale: 1,
        origin: "bottom"
    }), sr.reveal(".home .featured-companies h3, .home .featured-projects h3", {
        opacity: 0,
        distance: "10rem",
        duration: 1e3,
        scale: 1,
        origin: "bottom"
    }), sr.reveal(".home .sidebar-01, .home .sidebar-02, .home .footer", {
        opacity: 0,
        distance: "10rem",
        duration: 2e3,
        scale: 1,
        origin: "bottom"
    }), sr.reveal(".home .company-box, .home .project-box, .home .create-intro", {
        opacity: 0,
        distance: "10rem",
        duration: 1500,
        scale: 1,
        origin: "bottom"
    }))
});
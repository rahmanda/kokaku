$(function() {
    'use strict';
    var statistic = new Statistic();
    var form = new SchemaForm();
    form.init();
    form.setStat(statistic);

    var tab = new ContentTab();
    var upload = new Upload();
    var sideNav = new SideNav();

    upload.setForm(form);

    var navBar = new NavBar();

    var sideNav = new SideNav();

    var navContent = new NavContent();

    var metadatas = new Metadatas();

  });
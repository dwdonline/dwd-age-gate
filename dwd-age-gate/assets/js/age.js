jQuery(document).ready(function() {
  if (jQuery.cookie('dwdAgegate') != "true") {
    jQuery("#popup").show();
    jQuery(".button-yes").click(function() {
      jQuery("#popup").hide();
      // set the cookie for 24 hours
      var date = new Date();
      date.setTime(date.getTime() + 24 * 60 * 60 * 1000);
      jQuery.cookie('dwdAgegate', "true", {
		path: '/',
        expires: date
      });
    });
  }
});

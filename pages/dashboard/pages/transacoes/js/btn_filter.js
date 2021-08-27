$(function () {
  $("#btn_filter_show").click(function () {
    $(".popup_filter").removeClass("hidden");
  });

  $("#close_pop_up").click(function () {
    $(".popup_filter").addClass("hidden");
  });
});

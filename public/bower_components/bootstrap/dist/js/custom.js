
// Max Length

$('#title_post').maxlength({
  threshold: 10,
  warningClass: "label label-success",
  limitReachedClass: "label label-danger"
});

$('#description').maxlength({
  alwaysShow: true,
  threshold: 10,
  warningClass: "label label-success",
  limitReachedClass: "label label-danger"
});
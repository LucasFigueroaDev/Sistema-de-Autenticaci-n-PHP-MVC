function actionSubmit(field, value) {
    var x = document.createElement("INPUT");
    x.setAttribute("type", "hidden");
    x.setAttribute("name", field);
    x.setAttribute("id", field);
    if (value !== undefined) { x.setAttribute("value", value); }
    document.getElementById("form").appendChild(x);
    document.getElementById('form').submit();
}
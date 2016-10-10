function changeBoxes(action) {
  var f = document.forms[0];
  var elms = f.elements;
  for(var i = 0; i < elms.length; i++) {
    if(elms[i].type != 'checkbox'){ continue; }
    if(action < 0){
      elms[i].checked = elms[i].checked ? 0 : 1;
    } else {
      elms[i].checked = action;
    }
  }
}

var checklist = document.getElementById("chicklist");
var items = checklist.querySelectorAll("li");
var imputs = checklist.querySelectorAll("input");
for (var i = 0; i < items.length;i++) {
    items[i].addEventListener("click", editItem);
    imputs[i].addEventListener("blur", updateItem);
    imputs[i].addEventListener("keypress", itemKeypress);
}
function editItem() {
    this.className = "edit";
    var input = this.querySelector("input");
    input.focus();
    input.setSelectionRange(0, input.value.length);
}

function updateItem() {
    this.previousElementSibling.innerHTML = this.value;
    this.parentNode.className = "";
}
function itemKeypress(event) {
    if (event.which === 10);
    updateItem.call(this)
}


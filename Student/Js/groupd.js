function generateMember() {
    var container = document.getElementById("memberFieldsContainer");
    container.innerHTML = ""; // Clear any existing member fields


    var count = parseInt(document.getElementById("Members").value);
    if (count > 3) {
        count = 3;
        document.getElementById("Members").value = 3;
    }
    for (var i = 1; i < count; i++) {
        var label = document.createElement("label");
        var id = document.createElement("input");
        var inp = document.createElement("div");

        label.textContent = `Student ${i+1} ID: `;
        label.htmlFor = `id${i+1}`;

        // input.for = "Student 2" 
        id.type = "text";
        id.name = `id${i+1}`;
        id.id = `id${i+1}`;
        id.min = "0";
        id.placeholder = `Student ${i+1} id`; 
        inp.id = "Student_input";

        inp.classList.add("member"); // Add a CSS class to the div element
        label.classList.add("label"); // Add a CSS class to the label element
        id.classList.add("input-field");

        inp.appendChild(label);
        inp.appendChild(id);

        container.appendChild(inp);
    }
};
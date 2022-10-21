//Función para validar los datos del formulario

let button = document.getElementById('submitButton');

function validation(){
    errors = false;

    let name = document.getElementById('productName').value;
    let shortName = document.getElementById('shortName').value;
    let prize = document.getElementById('prize').value;
    let familyProduct = document.getElementById('familyProduct').value;
    let description = document.getElementById('description').value;

    document.getElementById('nameError').classList.remove('showedError');
    document.getElementById('shortNameError').classList.remove('showedError');
    document.getElementById('prizeError').classList.remove('showedError');
    document.getElementById('descriptionError').classList.remove('showedError');

    if(name == ""){
        errors = true;
        document.getElementById('nameError').classList.add('showedError')
    }

    if(shortName == ""){
        errors = true;
        document.getElementById('shortNameError').classList.add('showedError')
    }

    if(prize == "" || prize == 0){
        errors = true;
        document.getElementById('prizeError').classList.add('showedError')
    }

    if(description == ""){
        errors = true;
        document.getElementById('descriptionError').classList.add('showedError')
    }

    console.log(name,shortName,prize,familyProduct,description);

    if(errors){
        event.preventDefault();
    } else{
        return true;
    }
}

window.onload =() => {
    button.addEventListener('click', validation);
}

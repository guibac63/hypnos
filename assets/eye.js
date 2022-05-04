
const passwordEyeOne = document.getElementById("eye-password-one");
const passwordInputOne = document.getElementById("inputPassword")
const passwordEyeTwo = document.getElementById("eye-password-two");
const passwordInputTwo = document.getElementById("registration_form_plainPassword_first")
const passwordEyeThree = document.getElementById("eye-password-three");
const passwordInputThree = document.getElementById("registration_form_plainPassword_second")

//show / hide password when eye icon clicked
function showPassword(elt,input) {
    if(input.type !== "password"){
        elt.classList.remove('text-blue-400');
        elt.classList.add('text-black');
        input.type = "password"
    }else{
        elt.classList.remove('text-black');
        elt.classList.add('text-blue-400');
        input.type = "text"
    }
}

//listen login form
if(passwordEyeOne){
    passwordEyeOne.addEventListener('click',(evt)=>{
        showPassword(evt.currentTarget,passwordInputOne);
    });
}

//listen register form password
if(passwordEyeTwo) {
    passwordEyeTwo.addEventListener('click', (evt) => {
        showPassword(evt.currentTarget, passwordInputTwo);
    });
}
//listen register form password repeat
if(passwordEyeThree) {
    passwordEyeThree.addEventListener('click', (evt) => {
        showPassword(evt.currentTarget, passwordInputThree);
    });
}
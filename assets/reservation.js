const $ = require('jquery');

$(document).ready(function (){

    const baseUrl = document.location.origin
    const beginInput = document.getElementById("reservation_beginning_date")
    const endInput = document.getElementById("reservation_ending_date")
    const verifMessage = document.getElementById("verif_case")

    $("#reservation").submit(function(evt){

        //get the value of submitted dates
        const begin = beginInput.value
        const end = endInput.value

        //get the value of submitted suite
        const suite = document.getElementById("reservation_suite").value

        //convert it to unix to pass in URL AJAX params
        const bgn = Date.parse(begin)
        const ed = Date.parse(end)

        $.ajax({
            type:'GET',
            url: baseUrl + '/verifReservation/'+ suite +'/'+ bgn +'/'+ ed,
            dataType: "json",
            async: false

        })
            .done(function(response){

                let {data} = response

                // if there at least one condition no verifyed submit not allowed
                if(!data.verifAll){

                    //display error message for the user
                    if(!data.verif3){
                        verifMessage.innerText = "Les dates selectionnées sont déjà réservées. Veuillez consulter le calendrier"
                    }
                    if(!data.verif4){
                        verifMessage.innerText = "Impossible de réserver. la date d'arrivée se situe après la date de départ"
                    }
                    if(!data.verif2){
                        verifMessage.innerText = "Une réservation ne peut pas être effectuée plus d'un an à l'avance"
                    }
                    if(!data.verif1){
                        verifMessage.innerText = "Une réservation ne peut pas être effectuée dans le passé"
                    }

                    evt.preventDefault();
                }
            })
            .fail(function(error){
                console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                evt.preventDefault();
            })


    })

    //erase error message for a new submission
    beginInput.addEventListener("click",()=>{
        verifMessage.innerText = ""
    })

});
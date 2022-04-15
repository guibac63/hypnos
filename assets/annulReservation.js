const $ = require('jquery');

$(document).ready(function(){

    if(document.getElementsByClassName("annul-reservation")){


        const annulButtons = document.getElementsByClassName("annul-reservation");

        //make a listening in the annulation reservation buttons
        for(const button of annulButtons){
            button.addEventListener('click',(evt)=>{

                const baseUrl = document.location.origin

                let isExecuted=confirm("Voulez-vous réellement annuler cette réservation ?")

                //if annulation is coonfirmed make a post request to cancel reservation
                if(isExecuted){
                    console.log();
                    $.ajax({
                        type:'POST',
                        url: baseUrl + '/annulReservation',
                        dataType: "json",
                        data:{reservation:(button.id.slice(button.id.indexOf("-")+1))}

                    })
                        .done( function (response){

                            const {data} = response;
                            //create icone to substitue button
                            const cancelMessage = document.createElement("h1");
                            //preparing style of the element
                            cancelMessage.classList.add("text-xs","italic","font-bold","text-blue_dark_hypnos");
                            //give content to element
                            cancelMessage.innerText = "Réservation annulée"
                            //get the parent of the future element
                            const parentMessage = document.getElementById("elt-"+data)
                            //remove the button element
                            button.remove()
                            //add element to his parent
                            parentMessage.append(cancelMessage);



                        })

                        .fail(function(error){
                            console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                        })

                }

            })
        }


    }


})
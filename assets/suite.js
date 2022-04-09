const $ = require('jquery');

$(document).ready(function (){

    //function that make an ajax call to get suites who are linked to etablishments
    // and add possible options to select item
    const changeSelectSuite=()=>{
        const etbId = $('#reservation_etablissement').val()
        const suiteSelection = $("#reservation_suite");
        const baseUrl = document.location.origin
        let calendarElt = document.getElementById("calendrier");

        calendarElt.classList.add("hidden");

        if(etbId){
            $.ajax({
                type:'GET',
                url: baseUrl + '/datasuitename/'+ etbId,
                dataType: "json",

            })
                .done(function(response){

                    suiteSelection.html('');
                    let {data} = response

                    suiteSelection.append($("<option value selected >--Choix de la suite--</option>"))
                    //construction of the new select suite item
                    data.forEach(elt=>{
                            suiteSelection.append($("<option></option>")
                                .attr("value",elt.value).text(elt.text))
                        }
                    )
                    console.log(suiteSelection.val(),suiteSelection.text())
                    if(data.length !== 0){
                        suiteSelection.slideDown(10);
                    }else{
                        suiteSelection.slideUp(10);
                    }
                })
                .fail(function(error){
                    console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                })
        }else{
            suiteSelection.slideUp(10);
        }

    }

   $("#reservation_etablissement").change(function(){
       changeSelectSuite();
   })
});

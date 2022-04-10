const $ = require('jquery');

$(document).ready(function (){

    //function that make an ajax call to get suites who are linked to etablishments
    // and add possible options to select item
    const changeSelectSuite=()=>{
        const etbId = $('#reservation_etablissement').val()
        const suiteSelection = $("#reservation_suite");
        const baseUrl = document.location.origin
        let calendarElt = document.getElementById("calendrier");

        //hide the calendar
        calendarElt.classList.add("hidden");

        //if an etablishment is selected
        if(etbId){

            //remove all the value that not belong to the selected establishment
            $("#reservation_suite option").each(function() {
                if($(this).val()){
                    $(this).remove();
                }
            });

            $.ajax({
                type:'GET',
                url: baseUrl + '/datasuitename/'+ etbId,
                dataType: "json",

            })
                .done(function(response){

                   let {data} = response

                    //construction of the new select suite item
                    data.forEach(elt=>{
                            suiteSelection.append($("<option></option>")
                                .attr("value",elt.value).text(elt.text))
                        }
                    )
                })
                .fail(function(error){
                    console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                })
        }
    }

    //trigger once the request on loading
    changeSelectSuite();

    // trigger the request on establishment change
   $("#reservation_etablissement").change(function(){
      changeSelectSuite();
   })
});

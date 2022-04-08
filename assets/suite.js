const $ = require('jquery');

$(document).ready(function (){


    //function that make an ajax call to get suites who are linked to etablishments
    // and add possible options to select item
    const changeSelectSuite=()=>{
        const etbId = $('#reservation_etablissement').val()
        const baseUrl = document.location.origin
        $.ajax({
            type:'GET',
            url: baseUrl + '/datasuitename/'+ etbId,
            dataType: "json",

        })
            .done(function(response){
                const suiteSelection = $("#reservation_suite");
                suiteSelection.html('');
                let {data} = response

                //construction of the new select suite item
                data.forEach(elt=>{
                        suiteSelection.append($("<option></option>")
                            .attr("value",elt.value).text(elt.text))
                    }
                )
                console.log(data)
                if(data.length !== 0){
                    suiteSelection.slideDown();
                }else{
                    suiteSelection.slideUp();
                }
            })
            .fail(function(error){
                console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
            })
    }

   $("#reservation_etablissement").change(function(){
       changeSelectSuite();
   })


});

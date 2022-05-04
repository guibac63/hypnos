import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import timeGridPlugin from '@fullcalendar/timegrid';
import listPlugin from '@fullcalendar/list';
const $ = require('jquery');

$(document).ready(function (){

    const baseUrl = document.location.origin
    let calendarElt = document.getElementById("calendrier");
    const loader = document.getElementById("loader");

    //function that make an ajax call to get suites who are linked to etablishments
    // and add possible options to select item if no preselection by suite page
    const changeSelectSuite=(evt)=>{

        const etbId = $('#reservation_etablissement').val()
        const suiteSelection = $("#reservation_suite").val();

        const urlSlug = document.location.href.split('/');
        const selectedSuite = urlSlug.slice(urlSlug.indexOf('reservation')+1)

        //if an etablishment is selected
        if(etbId){
            //if the suite was preselected by the followed link in "suite" section", value was preselected
            if(selectedSuite.length !== 0 && typeof evt === "undefined"){
                $('#reservation_etablissement option[value="' + selectedSuite[0] +'"]').prop("selected",true);
                $('#reservation_suite option[value="' + selectedSuite[1] +'"]').prop("selected",true);
                console.log(evt)
                searchSuites(selectedSuite[0],selectedSuite[1])
                showCalendar()
            //if the selection was made by the user
            }else if(typeof evt !== undefined){
                console.log(evt)
                searchSuites(etbId)
                showCalendar()
            }else{
                console.log(evt)
                searchSuites(etbId)
            }
        }
    }

    const searchSuites = (etb,suite = 0) => {
        //hide the calendar for every user selection
        calendarElt.classList.add("hidden");

        let optionsInSuite = []
        console.log(suite)
        if(suite){
            console.log(suite)
            //get in array all the values of th suites
           $('#reservation_suite option').each(function(){
               optionsInSuite.push($(this).val())
           })
        }

        //remove all the value of the select suite
        if(!suite){
            $("#reservation_suite option").each(function() {
                if($(this).val()){
                    $(this).remove();
                }
            });
        }

        $.ajax({
            type:'GET',
            url: baseUrl + '/datasuitename/'+ etb,
            dataType: "json",
            //async:false
        })
            .done(function(response){

                let {data} = response
                //construction of the new select suite item
                if(!suite){
                    data.forEach(elt=>{
                            $("#reservation_suite").append($("<option></option>")
                                .attr("value",elt.value).text(elt.text))
                        }
                    )
                }else{
                    // get the values in array
                    const dataValues = data.map(elt=>
                        (elt.value).toString()
                    )

                    //get all the elements that must be removed (suites that no belongs to the selected establishments
                    let difference = optionsInSuite.filter(elt => dataValues.indexOf(elt) === -1 && elt !== "")

                    //remove elements from the select suite input
                    difference.forEach(elt=>{
                            $('#reservation_suite option[value="' + elt +'"]').remove()
                        }
                    )
                }

            })
            .fail(function(error){
                console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
            })
    }

    const showCalendar = () => {

        calendarElt.classList.add("hidden")

        const suiteSelection = $("#reservation_suite").val();

        if (suiteSelection) {
            loader.classList.remove("hidden")
            $.ajax({
                type: 'GET',
                url: baseUrl + '/reservationsuite/' + suiteSelection,
                dataType: "json",
            })
                .done(function (response) {
                    const {data} = response
                    let calendar = new Calendar(calendarElt, {
                        plugins: [dayGridPlugin, timeGridPlugin, listPlugin],
                        initialView: 'dayGridMonth',
                        headerToolbar: {
                            left: 'prev,next today',
                            center: 'title',
                            right: ''
                        },
                        events: data
                    });
                    calendarElt.classList.remove("hidden")
                    loader.classList.add("hidden")
                    calendar.render();

                })
                .fail(function (error) {
                    console.log("La requête s'est terminée en échec. Infos : " + JSON.stringify(error));
                })
        }else{
            calendarElt.classList.add("hidden")
        }
    }
    //trigger once the request on loading
    changeSelectSuite();

    // trigger the request on establishment change
   $("#reservation_etablissement").change(function(evt){
      changeSelectSuite(evt);
   })

    $("#reservation_suite").change(function(evt){
        showCalendar(evt);
    })
});

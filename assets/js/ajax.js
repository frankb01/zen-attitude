// charge mustache
import Mustache from 'mustache';

// Créer un objet pour manipuler ajax
var callAjax = {

    init: function(){

        // Si un stage extern a été validé ou dévalidé, 
        // la valeur de la variable est definit dans App\Controller\Teacher\StageController::validateApiStage()
        if ( teacherToggleInfo === "stages_extern" ) {

            $('#stages-toggle').bootstrapToggle('off');

            // Stages Externe
            callAjax.stagesExtern();
                
            // on ajoute les filtres
            $('#stages-extern-filter').show();

            // on cache le bouton nouveau stage interne
            if(currentPage == "teacher") {
                $('#new-stage').hide();
            }

            // on change la class css du filtre au focus et focusout de l'input
            $("#filtre-animateur1").focus(function() {
                $(this).prev().removeClass('text-white');
                $(this).prev().addClass('text-primary font-weight-bold');
            }).focusout(function() {
                $(this).prev().removeClass('text-primary font-weight-bold');
                $(this).prev().addClass('text-white');
            });

            $("#filtre-date").focus(function() {
                $(this).prev().removeClass('text-white');
                $(this).prev().addClass('text-primary font-weight-bold');
            }).focusout(function() {
                $(this).prev().removeClass('text-primary font-weight-bold');
                $(this).prev().addClass('text-white');
            });

            $("#filtre-place").focus(function() {
                $(this).prev().removeClass('text-white');
                $(this).prev().addClass('text-primary font-weight-bold');
            }).focusout(function() {
                $(this).prev().removeClass('text-primary font-weight-bold');
                $(this).prev().addClass('text-white');
            });
        }
        
        // on enleve les filtres car on est par default sur les stages intern
        var stagesExternFilter = $('#stages-extern-filter');

        if ( teacherToggleInfo !== "stages_extern" ) {
            stagesExternFilter.hide();
        }

        $('#stages-toggle').change(function() {

            if ( $(this).prop('checked') === true ) {
                // Stages Interne
                callAjax.stagesIntern();

                // on enleve les filtres
                stagesExternFilter.hide();

                // on affiche le bouton nouveau stage interne
                if(currentPage == "teacher") {
                    $('#new-stage').show();
                }

            } else {
                // Stages Externe
                callAjax.stagesExtern();
                
                // on ajoute les filtres
                stagesExternFilter.show();

                // on cache le bouton nouveau stage interne
                if(currentPage == "teacher") {
                    $('#new-stage').hide();
                }

                // on change la class css du filtre au focus et focusout de l'input
                $("#filtre-animateur1").focus(function() {
                    $(this).prev().removeClass('text-white');
                    $(this).prev().addClass('text-primary font-weight-bold');
                }).focusout(function() {
                    $(this).prev().removeClass('text-primary font-weight-bold');
                    $(this).prev().addClass('text-white');
                });

                $("#filtre-date").focus(function() {
                    $(this).prev().removeClass('text-white');
                    $(this).prev().addClass('text-primary font-weight-bold');
                }).focusout(function() {
                    $(this).prev().removeClass('text-primary font-weight-bold');
                    $(this).prev().addClass('text-white');
                });

                $("#filtre-place").focus(function() {
                    $(this).prev().removeClass('text-white');
                    $(this).prev().addClass('text-primary font-weight-bold');
                }).focusout(function() {
                    $(this).prev().removeClass('text-primary font-weight-bold');
                    $(this).prev().addClass('text-white');
                });
            }
        })
    },

    stagesIntern: function() {
        var stagesContainer = $('#list-stages');

        // on vide la liste des stages
        stagesContainer.empty();

        $.ajax(
            ajaxUrlStagesIntern, {
                method: 'POST',
                url: ajaxUrlStagesIntern,
                data: {
                    "stages": "intern",
                }
            }
        ).done(function(datas){ //datas contient le retour php effectué par la methode de mon controller

            var stagesBdd = [];

            // Pour chaque stage
            $.each(JSON.parse(datas['stages']), function(i, stage) {
                var data = {
                    id: stage.id,
                    name: stage.name,
                    date: stage.date,
                    place: stage.place,
                    href: (stage.poster !== null ? 'href="/uploads/media/' + stage.poster + '" target="_blank"' : 'href="#"')
                }

                stagesBdd.push(data);

                // on recupere le template ajouté dans la vue
                var template = $("#stage-template").html();

                var tags = ['(((', ')))'];

                var html = Mustache.render(template, data, null, tags);

                // ajoute le rendu dans la vue
                stagesContainer.append(html);
            })

            stagesBdd.forEach(function(stageBdd) {

                var stageDiv = $("#list-stages #" + stageBdd.id );
                var stageDivAction = stageDiv.find("div.stage-item-action");

                stageDivAction.empty();

                var actions = [
                    '<div class="col">',
                        '<a class="d-flex text-warning" href="/professeur/stage/' + stageBdd.id + '/modification">Modifier</a>',
                    '</div>',
                    '<div class="col">',
                        '<a class="confirmDeleteStage text-danger" href="/professeur/stage/' + stageBdd.id + '/suppression" >Supprimer</a>',
                    '</div>'
                ];

                stageDivAction.html( actions );
            });
        })
    },

    stagesExtern: function() {
        
        var stagesContainer = $('#list-stages');

        // filtre animateur1
        $("#filtre-animateur1").on("keyup", function() {
            // on annule les autre filtres 
            $("#filtre-date").val('');
            $("#filtre-place").val('');

            var value = $(this).val().toLowerCase();

            if (currentPage == "stage") {
                $("#list-stages a div h5").filter(function() {
                    var stageFiltred = $(this).parent().parent();
                    stageFiltred.toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            } else if(currentPage == "teacher") {
                $("#list-stages h5").filter(function() {
                    var stageFiltred = $(this).parent().parent();
                    stageFiltred.toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            }
        });

        // filtre date
        $("#filtre-date").on("keyup", function() {
            // on annule les autre filtres 
            $("#filtre-animateur1").val('');
            $("#filtre-place").val('');

            var value = $(this).val().toLowerCase();

            if (currentPage == "stage") {
                $("#list-stages a div small.stage-date").filter(function() {
                    var stageFiltred = $(this).parent().parent();
                    stageFiltred.toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            } else if(currentPage == "teacher") {
                $("#list-stages small.stage-date").filter(function() {
                    var stageFiltred = $(this).parent().parent();
                    stageFiltred.toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            }
        });

        // filtre place
        $("#filtre-place").on("keyup", function() {
            // on annule les autre filtres 
            $("#filtre-animateur1").val('');
            $("#filtre-date").val('');

            var value = $(this).val().toLowerCase();

            if (currentPage == "stage") {
                $("#list-stages a small.stage-place").filter(function() {
                    var stageFiltred = $(this).parent().parent();
                    stageFiltred.toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            } else if(currentPage == "teacher") {
                $("#list-stages small.stage-place").filter(function() {
                    var stageFiltred = $(this).parent().parent();
                    stageFiltred.toggle($(this).text().toLowerCase().indexOf(value) > -1);
                });
            }
        });
        
        // filtre suggest
        $("#filtre-suggest").on("click", function() {
            // on annule les autre filtres 
            $("#filtre-animateur1").val('');
            $("#filtre-date").val('');
            $("#filtre-place").val('');

            // on marque le filtre comme clicked ou non
            $(this).toggleClass('clicked');

            if ($(this).hasClass('clicked') === true) {
                $(this).find('span').html('Voir tous les stages')
            } else {
                $(this).find('span').html('filtrer par stages suggérés')
            }

            // on garde le filtre dans that
            var that = $(this);

            // on reset les fitltrages (show/hide du toogle) précedement effecetué
            $("#filtre-place").val( function() {

                // la valeur est vide car focer au debut du on click
                var value = this.value;
    
                if (currentPage == "stage") {
                    $("#list-stages a small.stage-place").filter(function() {
                        var stageFiltred = $(this).parent().parent();
                        if (that.hasClass('clicked') === true) {
                            stageFiltred.show($(this).text().toLowerCase().indexOf(value) > -1);
                        } else {
                            stageFiltred.hide($(this).text().toLowerCase().indexOf(value) > -1);
                        }
                    });
                } else if(currentPage == "teacher") {
                    $("#list-stages small.stage-place").filter(function() {
                        var stageFiltred = $(this).parent().parent();
                        if (that.hasClass('clicked') === true) {
                            stageFiltred.show($(this).text().toLowerCase().indexOf(value) > -1);
                        } else {
                            stageFiltred.hide($(this).text().toLowerCase().indexOf(value) > -1);
                        }
                    });
                }
            });

            // on filtre les stage sugggested
            if (currentPage == "stage") {
                // uniquement si le filtre est en possition clicked
                if ($(this).hasClass('clicked') === true) {
                    $("#list-stages a:not(.isSuggested)").filter(function() {
                        $(this).toggle();
                    });
                } else {
                    $("#list-stages a").show();
                }
            } else if(currentPage == "teacher") {
                // uniquement si le filtre est en possition clicked
                if ($(this).hasClass('clicked') === true) {
                    $("#list-stages div.list-group-item:not(.isSuggested)").filter(function() {
                        $(this).toggle();
                    });
                } else {
                    $("#list-stages div.list-group-item").show();
                }
            }
        });

        // on vide la liste des stages
        stagesContainer.empty();

        $.getJSON( ajaxUrlStagesExtern, function( data ) {

            var stagesApi = [];
            var stagesBdd = $.parseJSON(suggestedApiStage);

            $.each( data.stages, function( key, stage ) {

                var data = {
                    name: stage.animateur1,
                    // name: stage.titre,
                    date: stage.dateDebut,
                    dateHumaine: stage.dateHumaine,
                    place: stage.ville,
                    url: stage.url,
                    id: stage.id,
                    // Récupération de l'id de l'api et reconstruction de l'url de validation de stage
                    urlIdApi: '/professeur/stageapi/' + stage.id + '/'+ stage.animateur1 +'/'+ stage.dateHumaine +'/valider',
                    href: (stage.url !== null ? 'href="' + stage.url + '" target="_blank"' : 'href="#"')
                }

                // stock dans un tableau tous les stages provenant de l'api
                stagesApi.push(data);
                
                // on recupere le template ajouté dans la vue
                var template = $("#stage-template").html();
        
                var tags = ['(((', ')))'];
        
                var html = Mustache.render(template, data, null, tags);
        
                // ajoute le rendu dans la vue
                stagesContainer.append(html);
            });

            // Pour tous les stages api recolté
            stagesApi.forEach(function(stageApi) {
                stagesBdd.forEach(function(idStageBdd) {
                    if ( stageApi.id == idStageBdd ) {
                        if (currentPage == "stage") {
                            $("#" + stageApi.id).addClass('isSuggested').prepend("<i class='fas fa-user-ninja fa-2x mb-2'></i>");
                        } else if(currentPage == "teacher") {
                            $("#" + stageApi.id).addClass('isSuggested').prepend("<i class='fas fa-user-ninja fa-2x mb-2'></i>");
                            $("#" + stageApi.id + " .stage-item-action").empty();
                            $("#" + stageApi.id + " .stage-item-action").prepend( "<a class='text-danger' href='/professeur/stageapi/"+ stageApi.id +"/supprimer'>Retirer des suggestions</a>" );
                        }   
                    }
                });
            });
        });
    },
}

$(callAjax.init);
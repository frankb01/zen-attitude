(function ($) {
    // Modal pour confirmation de suppression
    var theHREF;

    // Modal user
    $(".confirmDeleteUser").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmDeleteModalUser").modal("show");
    });

    $("#confirmDeleteUserYes").click(function (e) {
        window.location.href = theHREF;
    });

    // Modal stage
    $(".confirmDeleteStage").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmDeleteModalStage").modal("show");
    });

    $("#confirmDeleteStageYes").click(function (e) {
        window.location.href = theHREF;
    });

    //Modal carsharing
    $(".confirmDeleteCarsharing").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmDeleteModalCarsharing").modal("show");
    });

    $("#confirmDeleteCarsharingYes").click(function (e) {
        window.location.href = theHREF;
    });

    //Modal JoinCarsharing
    $(".confirmJoinCarsharing").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmJoinModalCarsharing").modal("show");
    });

    $("#confirmJoinCarsharingYes").click(function (e) {
        window.location.href = theHREF;
    });

    //Modal UnjoinCarsharing
    $(".confirmUnjoinCarsharing").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmUnjoinModalCarsharing").modal("show");
    });

    $("#confirmUnjoinCarsharingYes").click(function (e) {
        window.location.href = theHREF;
    });
    
    // Modal news
    $(".confirmDeleteNews").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmDeleteModalNews").modal("show");
    });

    $("#confirmDeleteNewsYes").click(function (e) {
        window.location.href = theHREF;
    });

    // Modal timeSlot
    $(".confirmDeleteTimeSlot").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmDeleteModalTimeSlot").modal("show");
    });

    $("#confirmDeleteTimeSlotYes").click(function (e) {
        window.location.href = theHREF;
    });

    // Modal membership
    $(".confirmDeleteMembership").click(function (e) {
        e.preventDefault();
        theHREF = $(this).attr("href");
        $("#confirmDeleteModalMembership").modal("show");
    });

    $("#confirmDeleteMembershipYes").click(function (e) {
        window.location.href = theHREF;
    });



})(jQuery)
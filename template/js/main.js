$(document).ready(function () {

    function setIntervalImmediately(func, interval) {
        func();
        return setInterval(func, interval);
    }

    $(document).on('click', '.delete-node', function (e) {

        let nodeId = $(e.target).data('nodeId');

        $.post("/delete_node", {node_id: nodeId}, function () {
            let currentNode = $(".node[data-node-id='" + nodeId + "']");
            let parentNode = currentNode.parent().closest('.node');
            currentNode.closest('li').remove();
            if (parentNode.find('.children').children().length == 0) {
                parentNode.find('.hide-children').hide();
                parentNode.find('.show-children').hide();
            }
        }, "html");
    });

    $(document).on('click', '.delete-root-node', function (e) {

        let nodeId = $(e.target).data('nodeId');

        $('#delete-root-node-popup').data('nodeId', nodeId);
        $('#delete-root-node-popup').modal('show');

        let remainingSeconds = 20;

        let interval = setIntervalImmediately(function() {
            remainingSeconds = remainingSeconds - 1;
            $('#delete-root-node-popup-timer').html(remainingSeconds);
            if (remainingSeconds <= 0) {
                $('#delete-root-node-popup').modal('hide');
                clearInterval(interval);
            }
        }, 1000);

        $("#delete-root-node-popup").on("hide.bs.modal", function () {
            clearInterval(interval);
        });
    });

    $(document).on('click', '.delete-root-node-confirm', function () {

        let nodeId = $('#delete-root-node-popup').data('nodeId');

        $.post("/delete_node", {node_id: nodeId}, function () {
            $('#node-tree').empty();
            $("#create-root").show();
        }, "html");

        $('#delete-root-node-popup').modal('hide');
    });

    $(document).on('click', '.node-name', function (e) {

        let nodeId = $(e.target).data('nodeId');
        let name = $(e.target).text();

        $('#rename-node-popup').find('input#name').val(name);
        $('#rename-node-popup').data('nodeId', nodeId);
        $('#rename-node-popup').modal('show');
    });

    $(document).on('click', '.rename-node-confirm', function () {

        let nodeId = $('#rename-node-popup').data('nodeId');
        let newName = $('#rename-node-popup').find('input#name').val();

        $.post("/rename_node", {node_id: nodeId, name: newName}, function () {
            $(".node-name[data-node-id='" + nodeId + "']").html(newName);
        }, "html");

        $('#rename-node-popup').modal('hide');
    });

    $(document).on('click', '.create-node', function (e) {

        let nodeId = $(e.target).data('nodeId');
        let name = 'child node';

        $.post("/create_node", {parent_id: nodeId, name: name}, function (node) {
            $(".children[data-node-id='" + nodeId + "']").append('<li>'+ node +'</li>');
            $(".children[data-node-id='" + nodeId + "']").show();
            $(".hide-children[data-node-id='" + nodeId + "']").show();
            $(".show-children[data-node-id='" + nodeId + "']").hide();
        }, "html");
    });

    $(document).on('click', '#create-root', function () {

        let name = 'root';

        $.post("/create_node", {name: name, is_root: true}, function (node) {
            $("#node-tree").append(node);
            $("#create-root").hide();
        }, "html");
    });

    $(document).on('click', '.show-children', function (e) {

        let nodeId = $(e.target).data('nodeId');

        $(".children[data-node-id='" + nodeId + "']").show();
        $(".show-children[data-node-id='" + nodeId + "']").hide();
        $(".hide-children[data-node-id='" + nodeId + "']").show();
    });

    $(document).on('click', '.hide-children', function (e) {

        let nodeId = $(e.target).data('nodeId');

        $(".children[data-node-id='" + nodeId + "']").hide();
        $(".show-children[data-node-id='" + nodeId + "']").show();
        $(".hide-children[data-node-id='" + nodeId + "']").hide();
    });
});
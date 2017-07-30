$('#parent_name').autocomplete({
    source: function (request, response) {
        var result = [];
        var limit = 10;
        var term = request.term.toLowerCase();
        $.each(_opts.units, function () {
            var unit = this;
            if (term == '' || unit.unit_name.toLowerCase().indexOf(term) >= 0 ||
                (unit.parent_name && unit.parent_name.toLowerCase().indexOf(term) >= 0) ||
                (unit.unit_code && unit.unit_code.toLowerCase().indexOf(term) >= 0)) {
                result.push(unit);
                limit--;
                if (limit <= 0) {
                    return false;
                }
            }
        });
        response(result);
    },
    focus: function (event, ui) {
        $('#parent_name').val(ui.item.unit_name);
        return false;
    },
    select: function (event, ui) {
        $('#parent_name').val(ui.item.unit_name);
        $('#parent_id').val(ui.item.p_master_unit_id);
        return false;
    },
    search: function () {
        $('#parent_id').val('');
    }
}).autocomplete("instance")._renderItem = function (ul, item) {
    return $("<li>")
        .append($('<a>').append($('<b>').text(item.unit_name)).append('<br>')
            .append($('<i>').text(item.parent_name + ' | ' + item.unit_code)))
        .appendTo(ul);
};

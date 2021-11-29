$(document).ready(function ()
{
    $('form :input').on('change input', function()
    {
        $('button.save').removeAttr('disabled');
    });

    $('[data-toggle="tooltip"]').tooltip()

    $("#select_all").click(function ()
    {
        var all = $("input#select_all")[0];

        $("input.select-item").each(function (index, item)
        {
            $(item).prop("checked", all.checked);
        });
    });
});

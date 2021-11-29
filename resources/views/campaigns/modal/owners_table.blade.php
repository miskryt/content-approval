<div class="modal fade " id="owner_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="container-fluid">
                    <div class="row">
                        <table id="owners" class="table table-striped" style="width:100%">
                            <thead>
                            <tr>
                                <th class="">Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Creation date</th>
                            </tr>
                            </thead>

                            <tfoot>
                            <tr>
                                <th class="">Id</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Creation date</th>
                            </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" data-id="{{$id ?? ''}}" id="save_owner">Save changes</button>
            </div>
        </div>
    </div>
</div>


<script>
    $("#save_owner").on('click', function (button)
    {
        const u_id = $("#owners > tbody > tr.selected").find("td:nth-child(1)").text();
        const u_fname = $("#owners > tbody > tr.selected").find("td:nth-child(2)").text();
        const u_lname = $("#owners > tbody > tr.selected").find("td:nth-child(3)").text();

        $("[data-dismiss=modal]").trigger({type: "click"});
        $("#owner").html("<a href='/users/show/" + u_id + "'>" + u_fname + ' '+ u_lname + "</a>");
        $("input[name='user_id']").val(u_id);
        $('button.save').removeAttr('disabled');
    })
</script>

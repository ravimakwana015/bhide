<div class="modal fade" id="addRemoveGate" tabindex="-1" role="dialog" aria-labelledby="addRemoveGateTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Add Core</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered" style="text-align: center;">
                <thead>
                    <tr>
                        <th>Core</th>
                    </tr>
                </thead>
                <tbody id="gates"></tbody>
            </table>
            <hr />
            <form action="" method="POST" id="add_gate_form">
                @csrf
                <div class="form-group">
                    <label>Company Name</label>
                    <select class="form-control" name="company_id">
                        @foreach($companys as $key => $company)
                        <option value="{{ $key }}">{{ $company }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label>Core</label>
                    <input type="text" name="name" class="form-control" />
                </div>
                <button type="button" class="btn btn-outline-danger"
                onclick="addGate('{{ route('add.gates') }}')">Add Core</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
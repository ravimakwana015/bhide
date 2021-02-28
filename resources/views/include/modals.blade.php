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
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody id="gates"></tbody>
            </table>
            <hr />
            <form action="" method="POST" id="add_gate_form">
                @csrf
                <div class="form-group">
                    <label>Core</label>
                    <input type="text" name="name" class="form-control" />
                </div>
                <button type="button" class="btn btn-outline-danger"
                onclick="addGate('{{ route('add.gate') }}')">Add Core</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>


<div class="modal fade" id="addRemoveReason" tabindex="-1" role="dialog" aria-labelledby="addRemoveReasonTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Add Reason</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <table class="table table-bordered" style="text-align: center;">
                <thead>
                    <tr>
                        <th>Reason</th>
                        {{-- <th>Action</th> --}}
                    </tr>
                </thead>
                <tbody id="reasons"></tbody>
            </table>
            <hr />
            <form action="" method="POST" id="add_reason_form">
                @csrf
                <div class="form-group">
                    <label>Reason</label>
                    <input type="text" name="reason" class="form-control" />
                </div>
                <button type="button" class="btn btn-outline-danger"
                onclick="addReason('{{ route('add.reason') }}')">Add Reason</button>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="visitorCheckoutReason" tabindex="-1" role="dialog" aria-labelledby="visitorCheckoutReasonTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Visitor Checkout</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form action="" method="POST" id="checkout_form">
            <div class="modal-body">
                <div class="msg"></div>
                @csrf
                <div class="form-group">
                    <label>Check Out Date</label>
                    <input type="text" name="check_out_date" class="form-control datetimepicker" required/>
                </div>
                <div class="form-group">
                    <label>Check Out Time</label>
                    <input type="text" name="check_out_time" class="form-control timepicker" required/>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-danger" id="checkout_btn">Visitor Checkout</button>
                <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
            </div>
        </form>
    </div>
</div>
</div>
<div class="modal fade" id="pollResult" tabindex="-1" role="dialog" aria-labelledby="pollResultTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Poll Result</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="poll_result">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="pollResultUser" tabindex="-1" role="dialog" aria-labelledby="pollResultTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Submitted Users</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="poll_result_user">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>

<div class="modal fade" id="parcelsdetails" tabindex="-1" role="dialog" aria-labelledby="pollResultTitle"
aria-hidden="true">
<div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="deleteModalLongTitle">Total Parcels</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body" id="parcel_result_user">
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-dismiss="modal">Close</button>
        </div>
    </div>
</div>
</div>
<!-- Login Modal -->
<div class="modal fade login-modal" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            <div class="modal-body">
                <h2>Login</h2>
                <form method="POST" id="login-form">
                    {{csrf_field()}}
                    <div class="form-errors"></div>
                    @if (session()->has('missmatch'))
                    <div class="alert alert-danger">
                        {{session('missmatch')}}
                    </div>
                    @endif
                    <div class="form-item">
                        <label for="email">{{ __('Your Email Address') }}</label>
                        <input type="email" placeholder="{{ __('Enter Your Email Address') }}" name="email" value="{{old('email')}}">
                        <p style="margin:0px;clear:both;"></p>
                        @if ($errors->has('email'))
                        <p class="em">{{$errors->first('email')}}</p>
                        @endif
                    </div>
                    <div class="form-item">
                        <label for="psw">{{ __('Your Password') }}</label>
                        <input type="password" placeholder="{{ __('Enter Your Password') }}" name="password">
                        <p style="margin:0px;clear:both;"></p>
                        @if ($errors->has('password'))
                        <p class="em">{{$errors->first('password')}}</p>
                        @endif
                    </div>
                    
                    <div class="form-action">
                        <button class="btn" type="button" id="login-btn">{{ __('Login') }}</button>
                        {{-- <span>or</span>
                        <a href="javascript:void(0);" class="btn btn-login" data-toggle="modal" data-target="#exampleModal" data-dismiss="modal" aria-label="Close">Create Account</a> --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@push('js')
<script>
    $(document).ready(function () {
        $('#login-btn').click(function() {
            $('#login-form').validate({
                rules: {
                    email: {
                        required: true,
                    },
                    password: {
                        required: true,
                    },
                },
                messages:{
                    email:{
                        required: 'Please Enter Your Email',
                    },
                    password:{
                        required: 'Please Enter Your Password',
                    },
                },
            });
        });
    });
</script>
@endpush
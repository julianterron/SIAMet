<div class="row">
    <div class="col-lg-3 col-6">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{$users}}</h3>
                <p>Total Usuarios</p>
            </div>
            <div class="icon">
                <i class="fa fa-users"></i>
            </div>
            <a href="{{ route('user.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
    <div class="col-lg-3 col-6">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{$roles}}</h3>
                <p>Total Roles</p>
            </div>
            <div class="icon">
                <i class="fas fa-list-alt"></i>
            </div>
            <a href="{{ route('role.index') }}" class="small-box-footer">Ver <i class="fas fa-arrow-circle-right"></i></a>
        </div>
    </div>
</div>
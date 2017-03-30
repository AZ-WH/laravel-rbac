@include('admin.common.header')
<!--tab nav start-->
<section class="panel">
	<header class="panel-heading tab-bg-dark-navy-blue ">
		<ul class="nav nav-tabs">
			<li @if ($_active['_action'] == 'list')  class="active" @endif>
				<a href="/admin/roles">角色列表</a>
			</li>
			<li @if ($_active['_action'] == 'add')  class="active" @endif>
				<a href="/admin/role/add">添加角色</a>
			</li>
		</ul>
	</header>
	<div class="panel-body">
		<div class="tab-content">
			<div class="row">
				<div class="col-lg-4">
					<section class="panel">
						<table class="table table-striped table-advance table-hover">
							<thead>
							<tr>
								<th>名称</th>
								<th style="text-align: right">操作</th>
							</tr>
							</thead>
							<tbody>
							@foreach ($roles as $r)
								<tr class="role" role-id="{{ $r->id }}" role-name="{{ $r->name }}">
									<td>{{ $r->name }}</td>
									<td style="text-align: right">
										<div class="btn btn-primary btn-xs eye" role_id="{{ $r->id }}" data-toggle="modal" role_name="{{ $r->name }}" href="#permission"><i class="icon-eye-open"></i></div>
										<div role_id="{{ $r->id }}" role_name="{{ $r->name }}" class="btn btn-primary btn-xs update"><i class="icon-pencil"></i></div>
										<a href="/admin/roles/del/{{ $r->id }}" class="btn btn-danger btn-xs"><i class="icon-trash "></i></a>
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</section>
				</div>

				<div class="col-lg-8">
					<section class="panel">
						<table class="table table-striped table-advance table-hover">
							<thead>
							<tr>
								<th width="10%"><span style="color: #F77B6F" class="current_role"></span>权限</th>
								<th></th>
							</tr>
							</thead>
							<tbody>
							@foreach ($permissions as $p)
								<tr>
									<td>
										<label>
											<input class="permission father father-{{ $p->id }}" name="permission" type="checkbox" value="{{ $p->id }}">
											{{ $p->name }}
										</label>
									</td>
									<td style="text-align: left;border-left: 1px solid #ccc ">
										@foreach($p->child as $pc)
											<label style="margin-right: 10px;">
												<input class="permission child child-{{ $p->id }}" pid="{{ $p->id }}" name="permission" type="checkbox" value="{{ $pc->id }}">
												{{ $pc->name }}
											</label>
										@endforeach
									</td>
								</tr>
							@endforeach
							</tbody>
						</table>
					</section>
				</div>
			</div>
		</div>
	</div>
</section>
<!--tab nav start-->
<script>
	require(['app/auth' , 'common/common'] , function (auth , common) {
        common.checkboxSwitch();
        auth.updateRolePermission();
        auth.initRolePermission();
        auth.changRole();
        auth.updateRoleName();
        auth.doupdateRoleName();
    });
</script>

@include('admin.roles.edit')
@include('admin.common.footer')
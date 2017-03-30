@include('admin.common.header')
<!--main content start-->
<section id="main-content">
	<section class="wrapper">
		<!-- page start-->
		<div class="row">
			<div class="col-lg-12">
				<section class="panel">
					<header class="panel-heading">
						角色列表<a style='margin-left:20px;' class="btn btn-primary btn-xs" data-toggle="modal" href="#add"><i class="icon-plus"></i></a>
					</header>
					<table class="table table-striped table-advance table-hover">
						<thead>
						<tr>
							<th><i class="icon-bullhorn"></i>名称</th>
							<th><i class="icon-bullhorn"></i>描述</th>
							<th>操作</th>
						</tr>
						</thead>
						<tbody>
						@foreach ($roles as $r)
							<tr>
								<td>{{ $r->name }}</td>
								<td>{{ $r->description }}</td>
								<td>
									<div class="btn btn-primary btn-xs eye" role_id="{{ $r->id }}" data-toggle="modal" role_name="{{ $r->name }}" href="#permission"><i class="icon-eye-open"></i></div>
									<div role_id="{{ $r->id }}" data-toggle="modal" href="#edit" class="btn btn-primary btn-xs update"><i class="icon-pencil"></i></div>
									<a href="/alpha/role/del/{{ $r->id }}" class="btn btn-danger btn-xs"><i class="icon-trash "></i></a>
								</td>
							</tr>
						@endforeach
						</tbody>
					</table>
				</section>
			</div>
			

		</div>

	</section>

</section>
<!--main content end-->

@include('admin.common.footer')

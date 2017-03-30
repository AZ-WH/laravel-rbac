<script type="text/html" id="edit-role">
<div class="panel-body">
    <div class="tab-content">
        <div class="row cmxform form-horizontal tasi-form">
            <div class="col-lg-12">
                <section class="panel">
                    <div class="panel-body">
                        <div class="form-group ">
                            <label for="name" class="control-label col-lg-2">角色名称</label>
                            <div class="col-lg-10">
                                <input class="form-control form-item update-item" name="name" placeholder="" value="<%= roleName %>" type="text" />
                                <input class="form-control form-item update-item" name="id" placeholder="" value="<%= roleId %>" type="hidden" />
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
        <div class="col-lg-12 text-center">
            <button class="btn btn-danger form-submit update-form-button" type="button">修改</button>
        </div>
    </div>
</div>
</script>
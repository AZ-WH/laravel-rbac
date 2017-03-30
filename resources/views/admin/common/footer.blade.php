            </div>
        </section>
    </section>
    <!--main content end-->
    <!--footer start-->
    <footer class="site-footer">
        <div class="text-center">
            2013 &copy; FlatLab by VectorLab.
            <a href="#" class="go-top">
                <i class="icon-angle-up"></i>
            </a>
        </div>
    </footer>
    <!--footer end-->
</section>

<script src="{{ URL::asset('/') }}admin/js/libs/hover-dropdown.js"></script>
<script type="text/javascript" charset="utf-8" src="{{ URL::asset('/') }}admin/js/libs/baiduTemplate.js"></script>

<script>
    require(['common/common'] , function (common) {
        common.getCurrentUser();
    });
</script>

</body>
</html>
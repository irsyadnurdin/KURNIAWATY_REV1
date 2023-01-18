<?= $this->extend("admin/layout/admin_layout") ?>

<?= $this->section("content") ?>

<div class="app-main__inner">
    <div class="app-page-title">
        <div class="page-title-wrapper">
            <div class="page-title-heading">
                <div class="page-title-icon">
                    <i class="pe-7s-science icon-gradient bg-happy-itmeo"></i>
                </div>
                <div>
                    Dashboard
                    <div class="page-title-subheading">
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit. Nam eligendi quae eius perspiciatis. Totam quo sunt dignissimos qui aspernatur doloribus dolorum molestiae excepturi aut, facere delectus necessitatibus maiores eos blanditiis?
                    </div>
                </div>
            </div>
            <div class="page-title-actions">

            </div>
        </div>
    </div>
    <div class="row">

    </div>
</div>

<?= $this->endSection() ?>


<?= $this->section("javascript") ?>

<script type="text/javascript" language="javascript">
    $(document).ready(function() {
        $("#menu-dashboard").addClass("mm-active");
    })
</script>

<?= $this->endSection() ?>
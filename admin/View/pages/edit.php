<? $this->theme->header(); ?>

<div class="container">

    <div class="row">
        <div class="col page-title">
            <h4> <?= $page->title ?> </h4>
        </div>
    </div>

    <div class="row">
        <div class="col-9">
            <form enctype="multipart/form-data" name="add_content_form" method="post" action="" id="updateContentForm">

                <input type="hidden" name="pageId" id="pageId" value="<?= $page->id ?>" >

                <div class="form-group">
                    <label for="pageTitle">Title</label>
                    <input type="text" class="form-control" id="pageTitle" name="pageTitle" value="<?= $page->title ?>" >
                </div>

                <div class="form-group">
                    <label for="pageContent">Content</label>
                    <textarea class="form-control" id="pageContent" name="pageContent" rows="10"><?= $page->content ?></textarea>
                </div>

            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div>
                <button type="submit" class="btn btn-primary" id="btnUpdate">Update</button>
            </div>
        </div>
    </div>


</div>

<? $this->theme->footer(); ?>

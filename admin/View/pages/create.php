<? $this->theme->header(); ?>

<div class="container">
    <div class="row">
        <div class="col">
            <h4>Создать страницу</h4>
        </div>
    </div>
    <div class="row">
        <div class="col-9">
            <form enctype="multipart/form-data" name="add_content_form" method="post" action="" id="add_content_form">
                <div class="form-group">
                    <label for="pageTitle">Title</label>
                    <input type="text" class="form-control" id="pageTitle" name="pageTitle" placeholder="Title page...">
                </div>

                <div class="form-group">
                    <label for="pageContent">Content</label>
                    <textarea class="form-control" id="pageContent" name="pageContent" rows="10"></textarea>
                </div>
            </form>
        </div>
    </div>
    <div class="row">
        <div class="col-3">
            <div>
                <button type="submit" class="btn btn-primary" id="btnAddPage">Publish</button>
            </div>
        </div>
    </div>


</div>

<? $this->theme->footer(); ?>

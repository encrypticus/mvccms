<? $this->theme->header(); ?>

<div class="container">

    <div class="row">
        <div class="col">
            <h5>Редактировать книгу</h5>
        </div>
    </div>

    <div class="row">
        <div class="col-9">

            <form enctype="multipart/form-data" name="addBookForm" method="post" action="" id="updateBookForm">

                <input type="hidden" name="bookId" id="bookId" value="<?= $book->id ?>" >

                <div class="form-group">
                    <label for="title">Название</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= $book->title ?>" placeholder="Название книги...">
                </div>

                <div class="form-group">
                    <label for="author">Автор</label>
                    <input type="text" class="form-control" id="author" name="author" value="<?= $book->author ?>" placeholder="Автор...">
                </div>

                <div class="form-group">
                    <label for="year">Год издания</label>
                    <input type="text" class="form-control" id="year" name="year" value="<?= $book->year ?>" placeholder="Год издания...">
                </div>

                <div class="form-group">
                    <label for="description">Описание</label>
                    <textarea class="form-control" id="description" name="description" rows="7"><?= $book->description ?></textarea>
                </div>

                <div class="form-group">
                    <label for="shortDescription">Краткое описание</label>
                    <textarea class="form-control" id="shortDescription" name="shortDescription" rows="7"><?= $book->shortDescription ?></textarea>
                </div>

                <div class="form-group">
                    <label for="cover">Обложка</label>
                    <input type="file" name="cover" id="cover">
                    <img id="coverContainer" src="<?= $book->coverUrl ?>" width="50" title="<?= $book->title ?>"
                         alt="<?= $book->title ?>" style="outline: 1px solid #bcdff1">
                </div>

                <div class="form-group">
                    <label for="bookFile">Файл книги</label>
                    <input type="file" name="bookFile" id="bookFile">
                    <span id="urlContainer"> <?= $book->bookFileName ?> </span>
                </div>

                <div class="form-group">
                    <label for="category">Категория</label>
                    <select name="category" id="category" class="custom-select">

                        <? foreach ($items as $item): ?>

                            <option value = "<?=$item->category_id; ?>" <? if($book->categoryId == $item->category_id): ?> selected="selected" <?endif;?> > <?=$item->name ?> </option>

                        <? endforeach; ?>

                    </select>
                </div>

            </form>
        </div>
    </div>

    <div class="row">
        <div class="col-3">
            <div>
                <button type="submit" class="btn btn-primary" id="btnUpdateBook">Обновить книгу</button>
            </div>
        </div>
    </div>


</div>

<? $this->theme->footer(); ?>

<? $this->theme->header(); ?>

<main>
    <div class="container">

        <h3>Список книг</h3>

        <table class="table">

            <thead>
            <tr>
                <th>#</th>
                <th>Название</th>
                <th>Автор</th>
                <th>Категория</th>
                <th>Обложка</th>
                <th>Файл</th>
            </tr>
            </thead>

            <tbody>

            <? foreach ($books as $book): ?>

                <tr>
                    <th scope="row"> <?= $book->id ?> </th>

                    <td>
                        <a href="/admin/books/editBookPage/<?= $book->id ?>">
                            <?= $book->title ?>
                        </a>
                    </td>


                    <td> <?= $book->author ?> </td>

                    <td>
                        <? foreach ($categories as $category):
                            if($book->categoryId == $category->category_id) echo $category->name;
                        endforeach; ?>
                    </td>

                    <td>
                        <img src="<?= $book->coverUrl ?>" width="50" title="<?= $book->title ?>"
                             alt="<?= $book->title ?>" style="outline: 1px solid #bcdff1">
                    </td>

                    <td>
                        <a href="<?= $book->bookFileName ?>">Скачать</a>
                    </td>

                </tr>

            <? endforeach; ?>

            </tbody>

        </table>
    </div>
</main>

<? $this->theme->footer(); ?>

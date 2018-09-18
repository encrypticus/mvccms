<? $this->theme->header(); ?>

    <main>
        <div class="container">

            <h3>Pages</h3>

            <table class="table">

                <thead>
                <tr>
                    <th>#</th>
                    <th>Title</th>
                    <th>Date</th>
                </tr>
                </thead>

                <tbody>

                <? foreach ($pages as $page): ?>

                    <tr>
                        <th scope="row"> <?= $page->id ?> </th>

                        <td>
                            <a href="/admin/page/edit/<?= $page->id ?>" >
                                <?= $page->title ?>
                            </a>
                        </td>


                        <td> <?= $page->date ?> </td>
                    </tr>

                <? endforeach; ?>

                </tbody>

            </table>
        </div>
    </main>

<? $this->theme->footer(); ?>
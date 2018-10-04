<?php

namespace Admin\Model\Book;

use Engine\Core\Database\ActiveRecord;

/**
 * Class Book модель сущности Book
 * @package Admin\Model\Book
 */
class Book {
    use ActiveRecord;

    /**
     * @var string имя таблицы в БД
     */
    protected $table = 'books';

    /**
     * @var int id идентификатор книги в базе
     */
    public $id;

    /**
     * @return int
     */
    public function getId(): int {
        return $this->id;
    }

    /**
     * @param int $id
     * @return $this
     */
    public function setId(int $id) {
        $this->id = $id;
        return $this;
    }

    /**
     * @var string название книги
     */
    public $title;

    /**
     * @return string
     */
    public function getTitle(): string {
        return $this->title;
    }

    /**
     * @param string $title
     * @return $this
     */
    public function setTitle(string $title) {
        $this->title = $title;
        return $this;
    }

    /**
     * @var string автор книги
     */
    public $author;

    /**
     * @return string
     */
    public function getAuthor(): string {
        return $this->author;
    }

    /**
     * @param string $author
     * @return $this
     */
    public function setAuthor(string $author) {
        $this->author = $author;
        return $this;
    }

    /**
     * @var string путь к изображению обложки книги
     */
    public $coverUrl;

    /**
     * @return string
     */
    public function getCoverUrl():string {
        return $this->coverUrl;
    }

    /**
     * @param $coverUrl
     * @return $this
     */
    public function setCoverUrl($coverUrl) {
        $this->coverUrl = $coverUrl;
        return $this;
    }

    /**
     * @var string название файла книги
     */
    public $bookFileName;

    /**
     * @return string
     */
    public function getBookFileName(): string {
        return $this->bookFileName;
    }

    /**
     * @param string $bookFileName
     * @return $this
     */
    public function setBookFileName(string $bookFileName) {
        $this->bookFileName = $bookFileName;
        return $this;
    }

    /**
     * @var string год издания книги
     */
    public $year;

    /**
     * @return string
     */
    public function getYear(): string {
        return $this->year;
    }

    /**
     * @param string $year
     * @return $this
     */
    public function setYear(string $year) {
        $this->year = $year;
        return $this;
    }

    /**
     * @var string текст с описанием книги
     */
    public $description;

    /**
     * @var string текст с кратким описанием книги
     */
    public $shortDescription;

    /**
     * @return string
     */
    public function getShortDescription(): string {
        return $this->shortDescription;
    }

    /**
     * @param string $shortDescription
     * @return $this
     */
    public function setShortDescription(string $shortDescription) {
        $this->shortDescription = $shortDescription;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string {
        return $this->description;
    }

    /**
     * @param string $description
     * @return $this
     */
    public function setDescription(string $description) {
        $this->description = $description;
        return $this;
    }

    /**
     * @var int id категории книги
     */
    public $categoryId;

    /**
     * @return int
     */
    public function getCategoryId(): int {
        return $this->categoryId;
    }

    /**
     * @param int $categoryId
     * @return $this
     */
    public function setCategoryId(int $categoryId) {
        $this->categoryId = $categoryId;
        return $this;
    }

}
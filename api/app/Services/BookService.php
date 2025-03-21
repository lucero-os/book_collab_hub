<?php

namespace App\Services;

use App\Exceptions\CustomErrorException;
use App\Models\Book;
use App\Models\BookSection;
use Illuminate\Support\Facades\Cache;

class BookService
{
    protected CacheService $cacheService;

    public function __construct(CacheService $cacheService)
    {
        $this->cacheService = $cacheService;
    }

    public function createSection(array $data)
    {
        // Check book exists
        $book = Book::find($data['bookId']);
        if(!$book) throw new CustomErrorException('Book not found');

        // Check user has permissions to create section
        $loggedUser = auth()->user();
        if(!$loggedUser->hasBookPermission($book->id, 'create_book_section')) throw new CustomErrorException('Action not available');

        $bookSection = new BookSection();
        $bookSection->name = $data['name'];
        $bookSection->book_id = $book->id;

        if(isset($data['parentId'])){
            // Check book exists
            $parentSection = BookSection::find($data['parentId']);
            if(!$parentSection) throw new CustomErrorException('Parent section not found');

            $bookSection->parent_id = $parentSection->id;
        }
        $bookSection->content = ''; // initially empty
        $bookSection->save();

        // Cache new section tree
        $cacheKey = 'books_'.$book->id;
        $book = $book->load('sections.allChildren');
        $this->cacheService->replace($cacheKey, $book, 'json');
    }

    /**
     * Return a book with all sections and sub-sections
     * @param integer $bookId
     * @return Book $result
     * @throws CustomErrorException
     */
    public function getBook($bookId)
    {
        // Check book exists
        $book = Book::find($bookId);
        if(!$book) throw new CustomErrorException('Book not found');

        // Search for cached book
        $cacheKey = 'books_'.$bookId;
        $cachedBook = $this->cacheService->retrieve($cacheKey, 'json');

        if(!$cachedBook){
            $book = $book->load('sections.allChildren');
            // Load book on cache
            $this->cacheService->append($cacheKey, $book, 'json');
        }else{
            $book = $cachedBook;
        }

        return $book;
    }
}

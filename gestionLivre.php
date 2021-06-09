<?php
declare(strict_types=1);

require "autoload.php";
require "src/Utils.php";
require "src/ViewResearchBook.php";
init_php_session();

$authors = [];
$genres = [];
$years = [];
$editeurs = [];
$languages = [];
$research = "";
$filterId = 1;
$filterList = "";
$livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, 0);
$page = 1;
$booksContent = "";
$paginator = "";

if(isset($_GET['page']) && !empty($_GET['page']) && ctype_digit($_GET['page'])){
    if(!((int)($_GET['page']) <= 0)){
        $page = (int)($_GET['page']);
        $livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, $page-1);
    }
}

// Listes des Filtres ainsi que listes des livres à afficher //

if( (isset($_GET['author']) && !empty($_GET['author'])) || (isset($_GET['genre']) && !empty($_GET['genre']))
    || (isset($_GET['year']) && !empty($_GET['year'])) || (isset($_GET['editeur']) && !empty($_GET['editeur']))
    || (isset($_GET['langue']) && !empty($_GET['langue'])) || (isset($_GET['research']) && !empty($_GET['research']))) {
    if(isset($_GET['author']) && !empty($_GET['author'])){
        $authors = $_GET['author'];

        foreach($authors as $author){
            $value = $author;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Auteur</div> <input value='$value' type='text' name='author[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['genre']) && !empty($_GET['genre'])){
        $genres = $_GET['genre'];

        foreach($genres as $genre){
            $value = $genre;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Genre</div> <input value='$value' type='text' name='genre[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['year']) && !empty($_GET['year'])){
        $years = $_GET['year'];

        foreach($years as $year){
            $value = $year;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Année</div> <input value='$value' type='text' name='year[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['editeur']) && !empty($_GET['editeur'])){
        $editeurs = $_GET['editeur'];
        foreach($editeurs as $editeur){
            $value = $editeur;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Editeur</div> <input value='$value' type='text' name='editeur[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['langue']) && !empty($_GET['langue'])){
        $languages = $_GET['langue'];

        foreach($languages as $language){
            $value = $language;
            $filterList .= "<div id='$filterId' class='d-flex flex-row' style='margin-top: 3px;'> <div class='border-radius-5 margin-left margin-right w-25 white-background-color font-size-20 d-flex justify-content-center align-items-center'>Langue</div> <input value='$value' type='text' name='language[]'class='border-radius-5 margin-right flex-fill white-background-color d-flex justify-content-center align-items-center button-no-outline'> <div class='font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center' onClick='removeFilter(\"$filterId\")'> <svg width='48' height='48' viewBox='0 0 48 48' fill='none' xmlns='http://www.w3.org/2000/svg'><rect width='48' height='48' rx='5' fill='#E1534A'/><path d='M18.801 29.296C18.097 29.296 17.505 29.072 17.025 28.624C16.577 28.176 16.353 27.6 16.353 26.896C16.353 26.16 16.577 25.568 17.025 25.12C17.505 24.672 18.097 24.448 18.801 24.448H29.505C30.209 24.448 30.785 24.672 31.233 25.12C31.681 25.568 31.905 26.16 31.905 26.896C31.905 27.6 31.681 28.176 31.233 28.624C30.785 29.072 30.209 29.296 29.505 29.296H18.801Z' fill='#2F2F2F'/></svg></div> </div>";
            $filterId +=1;
        }
    }
    if(isset($_GET['research']) && !empty($_GET['research'])){
        $research = $_GET['research'];
    }
    $livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, $page-1);

    if(count($livres) == 0){
        $livres = $livres = Livre::getResearch($research, $authors, $years, $editeurs, $genres, $languages, 0);
    }
}
$max = count($livres);

// Contenue pour les livres //

foreach ($livres as $livre){
    $booksContent .= printResearchBookAdmin($livre->getISBN());
}

// Paginateur //

$query = $_GET;
$query['page']=$page-1;
$pred = http_build_query($query);
$query['page']=$page+1;
$next = http_build_query($query);
$query['page']=1;
$first = http_build_query($query);
$query['page']=intdiv($max, 30)+1;
$last = http_build_query($query);

$paginator .= <<<HTML
                <div class='d-flex main-background justify-content-between border-radius-100 w-75 m-4' style="padding-left: 10px; padding-right: 10px;">
                   <a class='font-size-20 p-2' href='{$_SERVER['PHP_SELF']}?$first'>
                       <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M11.3863 23.9998C10.7552 24.0006 10.1431 23.784 9.65295 23.3865L2.85295 17.7732C2.58629 17.5609 2.37094 17.2912 2.22293 16.9842C2.07491 16.6771 1.99805 16.3407 1.99805 15.9998C1.99805 15.659 2.07491 15.3226 2.22293 15.0155C2.37094 14.7085 2.58629 14.4388 2.85295 14.2265L9.65295 8.61318C10.0623 8.28517 10.5556 8.07876 11.0766 8.01747C11.5976 7.95618 12.1253 8.04247 12.5996 8.26651C13.0119 8.44822 13.3631 8.74475 13.6113 9.12067C13.8596 9.4966 13.9944 9.93604 13.9996 10.3865V21.6132C13.9944 22.0637 13.8596 22.5031 13.6113 22.879C13.3631 23.255 13.0119 23.5515 12.5996 23.7332C12.2185 23.9065 11.805 23.9974 11.3863 23.9998Z" fill="#D0D0D0"/>
                        <path d="M25.3882 24.0016C24.7572 24.0023 24.1451 23.7857 23.6549 23.3882L16.8549 17.7749C16.5882 17.5626 16.3729 17.2929 16.2249 16.9859C16.0769 16.6789 16 16.3424 16 16.0016C16 15.6607 16.0769 15.3243 16.2249 15.0172C16.3729 14.7102 16.5882 14.4405 16.8549 14.2282L23.6549 8.61489C24.0643 8.28688 24.5576 8.08047 25.0785 8.01918C25.5995 7.95789 26.1272 8.04418 26.6016 8.26822C27.0138 8.44993 27.365 8.74645 27.6133 9.12238C27.8615 9.49831 27.9963 9.93775 28.0016 10.3882V21.6149C27.9963 22.0654 27.8615 22.5048 27.6133 22.8807C27.365 23.2567 27.0138 23.5532 26.6016 23.7349C26.2204 23.9082 25.8069 23.9991 25.3882 24.0016Z" fill="#D0D0D0"/>
                        </svg>
                   </a>
                   <a class='font-size-20 no-decoration booki-link p-2' href='{$_SERVER['PHP_SELF']}?$pred'>Précédent</a>
                   <span class='font-size-20 main-text-color p-2'>$page</span>
                   <a class='font-size-20 no-decoration booki-link p-2' href='{$_SERVER['PHP_SELF']}?$next'>Suivant</a>
                   <a class='font-size-20 p-2' href='{$_SERVER['PHP_SELF']}?$last'>
                       <svg width="32" height="32" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                       <path d="M20.6137 8.00015C21.2448 7.9994 21.8569 8.21598 22.347 8.61348L29.147 14.2268C29.4137 14.4391 29.6291 14.7088 29.7771 15.0158C29.9251 15.3229 30.002 15.6593 30.002 16.0002C30.002 16.341 29.9251 16.6774 29.7771 16.9845C29.6291 17.2915 29.4137 17.5612 29.147 17.7735L22.347 23.3868C21.9377 23.7148 21.4444 23.9212 20.9234 23.9825C20.4024 24.0438 19.8747 23.9575 19.4004 23.7335C18.9881 23.5518 18.6369 23.2553 18.3887 22.8793C18.1404 22.5034 18.0056 22.064 18.0004 21.6135L18.0004 10.3868C18.0056 9.93635 18.1404 9.4969 18.3887 9.12098C18.6369 8.74505 18.9882 8.44853 19.4004 8.26682C19.7815 8.09349 20.195 8.00262 20.6137 8.00015Z" fill="#D0D0D0"/>
                       <path d="M6.61176 7.99844C7.24284 7.99769 7.85494 8.21427 8.3451 8.61177L15.1451 14.2251C15.4118 14.4374 15.6271 14.7071 15.7751 15.0141C15.9231 15.3211 16 15.6576 16 15.9984C16 16.3393 15.9231 16.6757 15.7751 16.9828C15.6271 17.2898 15.4118 17.5595 15.1451 17.7718L8.3451 23.3851C7.93572 23.7131 7.44243 23.9195 6.92145 23.9808C6.40047 24.0421 5.87275 23.9558 5.39843 23.7318C4.9862 23.5501 4.63498 23.2535 4.38673 22.8776C4.13847 22.5017 4.00367 22.0622 3.99843 21.6118L3.99843 10.3851C4.00367 9.93464 4.13847 9.49519 4.38673 9.11927C4.63498 8.74334 4.9862 8.44682 5.39843 8.26511C5.77959 8.09178 6.19305 8.00091 6.61176 7.99844Z" fill="#D0D0D0"/>
                       </svg>
                   </a>  
               </div>
HTML;



$header = getIndexHeader();
$content = <<<HTML
    <div class="header">
        <div class="d-flex flex-column dackdrop-blur h-100">
            $header
            <form class="d-flex justify-content-center flex-column flex-fill align-items-center" action="index.php" method="get">
                <span class="font-size-36 white-text-color">Rechercher</span>
                <div class="form-group research-button d-flex w-50 white-background-color button-no-outline border-radius-100">
                    <button type="submit" class="button-no-outline bg-transparent margin-left">
                        <svg width="36" height="36" viewBox="0 0 51 51" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M20.9461 3.64285C25.5353 3.64285 29.9366 5.4659 33.1816 8.71095C36.4267 11.956 38.2497 16.3572 38.2497 20.9464C38.2497 24.7386 37.0294 28.2449 34.962 31.0972L46.5573 42.6925C47.0586 43.1865 47.35 43.855 47.3706 44.5585C47.3912 45.2621 47.1395 45.9465 46.6679 46.469C46.1963 46.9915 45.5413 47.3119 44.8393 47.3634C44.1373 47.4148 43.4425 47.1933 42.8998 46.7451L42.6922 46.5575L31.097 34.9623C28.1466 37.1049 24.5924 38.256 20.9461 38.25C16.357 38.25 11.9557 36.4269 8.71068 33.1819C5.46563 29.9368 3.64258 25.5356 3.64258 20.9464C3.64258 16.3572 5.46563 11.956 8.71068 8.71095C11.9557 5.4659 16.357 3.64285 20.9461 3.64285ZM20.9461 9.10714C17.8062 9.10714 14.7948 10.3545 12.5745 12.5748C10.3542 14.7951 9.10686 17.8064 9.10686 20.9464C9.10686 24.0864 10.3542 27.0978 12.5745 29.3181C14.7948 31.5384 17.8062 32.7857 20.9461 32.7857C24.0861 32.7857 27.0975 31.5384 29.3178 29.3181C31.5381 27.0978 32.7854 24.0864 32.7854 20.9464C32.7854 17.8064 31.5381 14.7951 29.3178 12.5748C27.0975 10.3545 24.0861 9.10714 20.9461 9.10714Z" fill="#2F2F2F"/>
                        </svg>
                    </button>
                    <input type="text" name="research" class="flex-fill button-no-outline bg-transparent" value="$research">
                </div>
                <div class="d-flex justify-content-start w-50">
                    <span class="font-size-24 white-text-color">Filtre(s) :</span>
                    <div class="flex-fill">
                        <div class="d-flex flex-column flex-fill">
                            <div class="d-flex flex-fill">
                                <select id="filter-list" class="margin-left margin-right white-background-color flex-fill button-no-outline border-radius-5">
                                  <option value="author">Auteur</option>
                                  <option value="editeur">Editeur</option>
                                  <option value="genre">Genre</option>
                                  <option value="year">Année</option>
                                  <option value="language">Langue</option>
                                </select>
                                <div class="font-size-24 border-radius-5 main-color-background square-button d-flex justify-content-center align-items-center" onclick="addFilter()">
                                    <svg width="48" height="48" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <rect width="48" height="48" rx="5" fill="#E1B74A"/>
                                    <path d="M24.027 35.896C23.323 35.896 22.731 35.672 22.251 35.224C21.803 34.744 21.579 34.152 21.579 33.448V27.016H15.147C14.443 27.016 13.851 26.776 13.371 26.296C12.923 25.816 12.699 25.224 12.699 24.52C12.699 23.816 12.923 23.24 13.371 22.792C13.851 22.312 14.443 22.072 15.147 22.072H21.579V15.64C21.579 14.968 21.819 14.392 22.299 13.912C22.811 13.432 23.387 13.192 24.027 13.192C24.763 13.192 25.355 13.432 25.803 13.912C26.251 14.36 26.475 14.936 26.475 15.64V22.072H32.907C33.579 22.072 34.155 22.312 34.635 22.792C35.147 23.272 35.403 23.864 35.403 24.568C35.403 25.24 35.147 25.816 34.635 26.296C34.155 26.776 33.579 27.016 32.907 27.016H26.475V33.448C26.475 34.152 26.251 34.744 25.803 35.224C25.355 35.672 24.763 35.896 24.027 35.896Z" fill="#2F2F2F"/>
                                    </svg>
                                </div>
                            </div>
                            <div id="filters" class="d-flex flex-column flex-fill">
                                $filterList
                            </div>
                        </div>
                        
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex flex-row justify-content-center pt-4 pb-2">
        <div class="d-flex flex-column">
            <div class="d-flex flex-row justify-content-center">
                <div class="d-inline-flex">
                    <a href="addBook.php" class="btn font-size-36 main-color-background dark-text border-radius-5 padding-button font-weight-bold button">
                        <svg width="465" height="80" viewBox="0 0 465 80" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <rect width="465" height="80" rx="5" fill="#E1B74A"/>
                            <path d="M56.333 50C55.7357 50 55.277 49.744 54.957 49.232C54.637 48.72 54.605 48.176 54.861 47.6L63.853 26.128C64.173 25.3813 64.6957 25.008 65.421 25.008C66.189 25.008 66.7117 25.3813 66.989 26.128L76.013 47.664C76.2477 48.2613 76.205 48.8053 75.885 49.296C75.5863 49.7653 75.1277 50 74.509 50C74.189 50 73.8797 49.9147 73.581 49.744C73.3037 49.552 73.101 49.296 72.973 48.976L71.181 44.496H59.693L57.869 48.976C57.7197 49.3173 57.4957 49.5733 57.197 49.744C56.9197 49.9147 56.6317 50 56.333 50ZM60.813 41.744H70.061L65.485 30.352L60.813 41.744ZM75.025 57.488C74.5557 57.488 74.1717 57.328 73.873 57.008C73.5743 56.7093 73.425 56.3253 73.425 55.856C73.425 55.3653 73.5743 54.9707 73.873 54.672C74.1717 54.3733 74.5557 54.224 75.025 54.224C76.2837 54.224 77.3183 53.8187 78.129 53.008C78.9397 52.1973 79.345 51.1733 79.345 49.936V34.128C79.345 33.6373 79.4943 33.2427 79.793 32.944C80.113 32.6453 80.5077 32.496 80.977 32.496C81.4677 32.496 81.8623 32.6453 82.161 32.944C82.4597 33.2427 82.609 33.6373 82.609 34.128V49.936C82.609 51.408 82.2783 52.7093 81.617 53.84C80.977 54.9707 80.0917 55.856 78.961 56.496C77.8303 57.1573 76.5183 57.488 75.025 57.488ZM80.977 29.648C80.401 29.648 79.8997 29.4453 79.473 29.04C79.0677 28.6133 78.865 28.112 78.865 27.536C78.865 26.96 79.0677 26.4693 79.473 26.064C79.8997 25.6373 80.401 25.424 80.977 25.424C81.553 25.424 82.0437 25.6373 82.449 26.064C82.8757 26.4693 83.089 26.96 83.089 27.536C83.089 28.112 82.8757 28.6133 82.449 29.04C82.0437 29.4453 81.553 29.648 80.977 29.648ZM95.3473 50.128C93.6193 50.128 92.0939 49.7547 90.7713 49.008C89.4486 48.24 88.4033 47.1947 87.6353 45.872C86.8886 44.528 86.5153 42.992 86.5153 41.264C86.5153 39.5147 86.8886 37.9787 87.6353 36.656C88.4033 35.312 89.4486 34.2667 90.7713 33.52C92.0939 32.752 93.6193 32.368 95.3473 32.368C97.0539 32.368 98.5686 32.752 99.8913 33.52C101.214 34.2667 102.249 35.312 102.995 36.656C103.763 37.9787 104.147 39.5147 104.147 41.264C104.147 42.992 103.774 44.528 103.027 45.872C102.281 47.1947 101.246 48.24 99.9233 49.008C98.6006 49.7547 97.0753 50.128 95.3473 50.128ZM95.3473 47.248C96.4566 47.248 97.4379 46.992 98.2913 46.48C99.1446 45.968 99.8059 45.264 100.275 44.368C100.766 43.472 101.011 42.4373 101.011 41.264C101.011 40.0907 100.766 39.056 100.275 38.16C99.8059 37.2427 99.1446 36.528 98.2913 36.016C97.4379 35.504 96.4566 35.248 95.3473 35.248C94.2379 35.248 93.2566 35.504 92.4033 36.016C91.5499 36.528 90.8779 37.2427 90.3873 38.16C89.8966 39.056 89.6513 40.0907 89.6513 41.264C89.6513 42.4373 89.8966 43.472 90.3873 44.368C90.8779 45.264 91.5499 45.968 92.4033 46.48C93.2566 46.992 94.2379 47.248 95.3473 47.248ZM116.365 50.16C114.893 50.16 113.57 49.8507 112.397 49.232C111.245 48.592 110.328 47.664 109.645 46.448C108.984 45.232 108.653 43.7387 108.653 41.968V34.096C108.653 33.6267 108.802 33.2427 109.101 32.944C109.421 32.624 109.816 32.464 110.285 32.464C110.754 32.464 111.138 32.624 111.437 32.944C111.757 33.2427 111.917 33.6267 111.917 34.096V41.968C111.917 43.7813 112.397 45.1147 113.357 45.968C114.338 46.8 115.554 47.216 117.005 47.216C117.922 47.216 118.733 47.0347 119.437 46.672C120.162 46.3093 120.738 45.8187 121.165 45.2C121.592 44.5813 121.805 43.888 121.805 43.12V34.096C121.805 33.6053 121.954 33.2107 122.253 32.912C122.573 32.6133 122.968 32.464 123.437 32.464C123.928 32.464 124.322 32.6133 124.621 32.912C124.92 33.2107 125.069 33.6053 125.069 34.096V48.368C125.069 48.8373 124.92 49.232 124.621 49.552C124.322 49.8507 123.928 50 123.437 50C122.968 50 122.573 49.8507 122.253 49.552C121.954 49.232 121.805 48.8373 121.805 48.368V48.016C121.144 48.6773 120.344 49.2 119.405 49.584C118.466 49.968 117.453 50.16 116.365 50.16ZM137.186 50C136.119 50 135.159 49.7333 134.306 49.2C133.452 48.6453 132.78 47.8987 132.29 46.96C131.799 46.0213 131.554 44.9653 131.554 43.792V35.888H130.082C129.634 35.888 129.271 35.76 128.993 35.504C128.716 35.248 128.578 34.928 128.578 34.544C128.578 34.1173 128.716 33.776 128.993 33.52C129.271 33.264 129.634 33.136 130.082 33.136H131.554V28.528C131.554 28.0587 131.703 27.6747 132.002 27.376C132.3 27.0773 132.684 26.928 133.154 26.928C133.623 26.928 134.007 27.0773 134.306 27.376C134.604 27.6747 134.754 28.0587 134.754 28.528V33.136H137.474C137.922 33.136 138.284 33.264 138.562 33.52C138.839 33.776 138.978 34.1173 138.978 34.544C138.978 34.928 138.839 35.248 138.562 35.504C138.284 35.76 137.922 35.888 137.474 35.888H134.754V43.792C134.754 44.6453 134.988 45.36 135.458 45.936C135.927 46.512 136.503 46.8 137.186 46.8H138.274C138.658 46.8 138.978 46.9493 139.234 47.248C139.511 47.5467 139.65 47.9307 139.65 48.4C139.65 48.8693 139.468 49.2533 139.106 49.552C138.764 49.8507 138.316 50 137.762 50H137.186ZM151.885 50.128C150.115 50.128 148.536 49.7547 147.149 49.008C145.784 48.24 144.707 47.1947 143.917 45.872C143.149 44.528 142.765 42.992 142.765 41.264C142.765 39.5147 143.128 37.9787 143.853 36.656C144.6 35.312 145.624 34.2667 146.925 33.52C148.227 32.752 149.72 32.368 151.405 32.368C153.069 32.368 154.499 32.7413 155.693 33.488C156.888 34.2133 157.795 35.2267 158.413 36.528C159.053 37.808 159.373 39.2907 159.373 40.976C159.373 41.3813 159.235 41.7227 158.957 42C158.68 42.256 158.328 42.384 157.901 42.384H145.741C145.976 43.856 146.648 45.0613 147.757 46C148.888 46.9173 150.264 47.376 151.885 47.376C152.547 47.376 153.219 47.2587 153.901 47.024C154.605 46.768 155.171 46.48 155.597 46.16C155.917 45.9253 156.259 45.808 156.621 45.808C157.005 45.7867 157.336 45.8933 157.613 46.128C157.976 46.448 158.168 46.8 158.189 47.184C158.211 47.568 158.04 47.8987 157.677 48.176C156.952 48.752 156.045 49.2213 154.957 49.584C153.891 49.9467 152.867 50.128 151.885 50.128ZM151.405 35.12C149.827 35.12 148.557 35.5573 147.597 36.432C146.637 37.3067 146.029 38.4373 145.773 39.824H156.429C156.237 38.4587 155.715 37.3387 154.861 36.464C154.008 35.568 152.856 35.12 151.405 35.12ZM165.136 50C164.07 50 163.536 49.4667 163.536 48.4V34.096C163.536 33.0293 164.07 32.496 165.136 32.496C166.203 32.496 166.736 33.0293 166.736 34.096V34.704C167.376 33.9573 168.155 33.3707 169.072 32.944C170.011 32.5173 171.024 32.304 172.112 32.304C173.392 32.304 174.342 32.5173 174.96 32.944C175.6 33.3493 175.846 33.84 175.696 34.416C175.59 34.864 175.376 35.1627 175.056 35.312C174.736 35.44 174.363 35.4613 173.936 35.376C172.571 35.0987 171.344 35.0773 170.256 35.312C169.168 35.5467 168.304 35.984 167.664 36.624C167.046 37.264 166.736 38.0747 166.736 39.056V48.4C166.736 49.4667 166.203 50 165.136 50ZM195.834 50.16C194.362 50.16 193.039 49.8507 191.866 49.232C190.714 48.592 189.796 47.664 189.114 46.448C188.452 45.232 188.122 43.7387 188.122 41.968V34.096C188.122 33.6267 188.271 33.2427 188.57 32.944C188.89 32.624 189.284 32.464 189.754 32.464C190.223 32.464 190.607 32.624 190.906 32.944C191.226 33.2427 191.386 33.6267 191.386 34.096V41.968C191.386 43.7813 191.866 45.1147 192.826 45.968C193.807 46.8 195.023 47.216 196.474 47.216C197.391 47.216 198.202 47.0347 198.906 46.672C199.631 46.3093 200.207 45.8187 200.634 45.2C201.06 44.5813 201.274 43.888 201.274 43.12V34.096C201.274 33.6053 201.423 33.2107 201.722 32.912C202.042 32.6133 202.436 32.464 202.906 32.464C203.396 32.464 203.791 32.6133 204.09 32.912C204.388 33.2107 204.538 33.6053 204.538 34.096V48.368C204.538 48.8373 204.388 49.232 204.09 49.552C203.791 49.8507 203.396 50 202.906 50C202.436 50 202.042 49.8507 201.722 49.552C201.423 49.232 201.274 48.8373 201.274 48.368V48.016C200.612 48.6773 199.812 49.2 198.874 49.584C197.935 49.968 196.922 50.16 195.834 50.16ZM211.918 50.032C211.449 50.032 211.054 49.8827 210.734 49.584C210.436 49.264 210.286 48.8693 210.286 48.4V34.128C210.286 33.6373 210.436 33.2427 210.734 32.944C211.054 32.6453 211.449 32.496 211.918 32.496C212.409 32.496 212.804 32.6453 213.102 32.944C213.401 33.2427 213.55 33.6373 213.55 34.128V34.48C214.212 33.8187 215.012 33.296 215.95 32.912C216.889 32.528 217.902 32.336 218.99 32.336C220.462 32.336 221.774 32.656 222.926 33.296C224.1 33.9147 225.017 34.832 225.678 36.048C226.361 37.264 226.702 38.7573 226.702 40.528V48.4C226.702 48.8693 226.542 49.264 226.222 49.584C225.924 49.8827 225.54 50.032 225.07 50.032C224.601 50.032 224.206 49.8827 223.886 49.584C223.588 49.264 223.438 48.8693 223.438 48.4V40.528C223.438 38.7147 222.948 37.392 221.966 36.56C221.006 35.7067 219.801 35.28 218.35 35.28C217.454 35.28 216.644 35.4613 215.918 35.824C215.193 36.1867 214.617 36.6773 214.19 37.296C213.764 37.8933 213.55 38.5867 213.55 39.376V48.4C213.55 48.8693 213.401 49.264 213.102 49.584C212.804 49.8827 212.409 50.032 211.918 50.032ZM240.802 50C240.204 50 239.746 49.744 239.426 49.232C239.106 48.72 239.074 48.176 239.33 47.6L248.322 26.128C248.642 25.3813 249.164 25.008 249.89 25.008C250.658 25.008 251.18 25.3813 251.458 26.128L260.482 47.664C260.716 48.2613 260.674 48.8053 260.354 49.296C260.055 49.7653 259.596 50 258.978 50C258.658 50 258.348 49.9147 258.05 49.744C257.772 49.552 257.57 49.296 257.442 48.976L255.65 44.496H244.162L242.338 48.976C242.188 49.3173 241.964 49.5733 241.666 49.744C241.388 49.9147 241.1 50 240.802 50ZM245.282 41.744H254.53L249.954 30.352L245.282 41.744ZM265.574 50C264.507 50 263.974 49.4667 263.974 48.4V34.096C263.974 33.0293 264.507 32.496 265.574 32.496C266.64 32.496 267.174 33.0293 267.174 34.096V34.704C267.814 33.9573 268.592 33.3707 269.51 32.944C270.448 32.5173 271.462 32.304 272.55 32.304C273.83 32.304 274.779 32.5173 275.398 32.944C276.038 33.3493 276.283 33.84 276.134 34.416C276.027 34.864 275.814 35.1627 275.494 35.312C275.174 35.44 274.8 35.4613 274.374 35.376C273.008 35.0987 271.782 35.0773 270.694 35.312C269.606 35.5467 268.742 35.984 268.102 36.624C267.483 37.264 267.174 38.0747 267.174 39.056V48.4C267.174 49.4667 266.64 50 265.574 50ZM285.904 50C284.838 50 283.878 49.7333 283.024 49.2C282.171 48.6453 281.499 47.8987 281.008 46.96C280.518 46.0213 280.272 44.9653 280.272 43.792V35.888H278.8C278.352 35.888 277.99 35.76 277.712 35.504C277.435 35.248 277.296 34.928 277.296 34.544C277.296 34.1173 277.435 33.776 277.712 33.52C277.99 33.264 278.352 33.136 278.8 33.136H280.272V28.528C280.272 28.0587 280.422 27.6747 280.72 27.376C281.019 27.0773 281.403 26.928 281.872 26.928C282.342 26.928 282.726 27.0773 283.024 27.376C283.323 27.6747 283.472 28.0587 283.472 28.528V33.136H286.192C286.64 33.136 287.003 33.264 287.28 33.52C287.558 33.776 287.696 34.1173 287.696 34.544C287.696 34.928 287.558 35.248 287.28 35.504C287.003 35.76 286.64 35.888 286.192 35.888H283.472V43.792C283.472 44.6453 283.707 45.36 284.176 45.936C284.646 46.512 285.222 46.8 285.904 46.8H286.992C287.376 46.8 287.696 46.9493 287.952 47.248C288.23 47.5467 288.368 47.9307 288.368 48.4C288.368 48.8693 288.187 49.2533 287.824 49.552C287.483 49.8507 287.035 50 286.48 50H285.904ZM294.332 50C293.863 50 293.468 49.8507 293.148 49.552C292.849 49.232 292.7 48.8373 292.7 48.368V34.128C292.7 33.6373 292.849 33.2427 293.148 32.944C293.468 32.6453 293.863 32.496 294.332 32.496C294.823 32.496 295.217 32.6453 295.516 32.944C295.815 33.2427 295.964 33.6373 295.964 34.128V48.368C295.964 48.8373 295.815 49.232 295.516 49.552C295.217 49.8507 294.823 50 294.332 50ZM294.332 29.648C293.756 29.648 293.255 29.4453 292.828 29.04C292.423 28.6133 292.22 28.112 292.22 27.536C292.22 26.96 292.423 26.4693 292.828 26.064C293.255 25.6373 293.756 25.424 294.332 25.424C294.908 25.424 295.399 25.6373 295.804 26.064C296.231 26.4693 296.444 26.96 296.444 27.536C296.444 28.112 296.231 28.6133 295.804 29.04C295.399 29.4453 294.908 29.648 294.332 29.648ZM309.972 50.128C308.266 50.128 306.74 49.744 305.396 48.976C304.074 48.1867 303.028 47.1307 302.26 45.808C301.514 44.464 301.14 42.9493 301.14 41.264C301.14 39.536 301.514 38 302.26 36.656C303.007 35.312 304.031 34.2667 305.332 33.52C306.634 32.752 308.127 32.368 309.812 32.368C312.33 32.368 314.42 33.328 316.084 35.248C316.383 35.5893 316.49 35.9413 316.404 36.304C316.319 36.6667 316.084 36.9867 315.7 37.264C315.402 37.4773 315.071 37.552 314.708 37.488C314.346 37.4027 314.015 37.2107 313.716 36.912C312.671 35.8027 311.37 35.248 309.812 35.248C308.17 35.248 306.836 35.8027 305.812 36.912C304.788 38 304.276 39.4507 304.276 41.264C304.276 42.416 304.511 43.44 304.98 44.336C305.471 45.232 306.143 45.9467 306.996 46.48C307.85 46.992 308.842 47.248 309.972 47.248C311.423 47.248 312.596 46.8747 313.492 46.128C313.834 45.8507 314.186 45.7013 314.548 45.68C314.911 45.6373 315.231 45.7333 315.508 45.968C315.871 46.2667 316.074 46.608 316.116 46.992C316.159 47.3547 316.031 47.6853 315.732 47.984C314.196 49.4133 312.276 50.128 309.972 50.128ZM325.415 50C324.476 50 323.644 49.744 322.919 49.232C322.194 48.72 321.628 48.0267 321.223 47.152C320.818 46.256 320.615 45.232 320.615 44.08V26.608C320.615 26.1387 320.764 25.7547 321.063 25.456C321.362 25.1573 321.746 25.008 322.215 25.008C322.684 25.008 323.068 25.1573 323.367 25.456C323.666 25.7547 323.815 26.1387 323.815 26.608V44.08C323.815 44.8693 323.964 45.52 324.263 46.032C324.562 46.544 324.946 46.8 325.415 46.8H326.215C326.642 46.8 326.983 46.9493 327.239 47.248C327.516 47.5467 327.655 47.9307 327.655 48.4C327.655 48.8693 327.452 49.2533 327.047 49.552C326.642 49.8507 326.119 50 325.479 50H325.415ZM338.104 50.128C336.333 50.128 334.755 49.7547 333.368 49.008C332.003 48.24 330.925 47.1947 330.136 45.872C329.368 44.528 328.984 42.992 328.984 41.264C328.984 39.5147 329.347 37.9787 330.072 36.656C330.819 35.312 331.843 34.2667 333.144 33.52C334.445 32.752 335.939 32.368 337.624 32.368C339.288 32.368 340.717 32.7413 341.912 33.488C343.107 34.2133 344.013 35.2267 344.632 36.528C345.272 37.808 345.592 39.2907 345.592 40.976C345.592 41.3813 345.453 41.7227 345.176 42C344.899 42.256 344.547 42.384 344.12 42.384H331.96C332.195 43.856 332.867 45.0613 333.976 46C335.107 46.9173 336.483 47.376 338.104 47.376C338.765 47.376 339.437 47.2587 340.12 47.024C340.824 46.768 341.389 46.48 341.816 46.16C342.136 45.9253 342.477 45.808 342.84 45.808C343.224 45.7867 343.555 45.8933 343.832 46.128C344.195 46.448 344.387 46.8 344.408 47.184C344.429 47.568 344.259 47.8987 343.896 48.176C343.171 48.752 342.264 49.2213 341.176 49.584C340.109 49.9467 339.085 50.128 338.104 50.128ZM337.624 35.12C336.045 35.12 334.776 35.5573 333.816 36.432C332.856 37.3067 332.248 38.4373 331.992 39.824H342.648C342.456 38.4587 341.933 37.3387 341.08 36.464C340.227 35.568 339.075 35.12 337.624 35.12Z" fill="#2F2F2F"/>
                            <path d="M414.027 51.896C413.323 51.896 412.731 51.672 412.251 51.224C411.803 50.744 411.579 50.152 411.579 49.448V43.016H405.147C404.443 43.016 403.851 42.776 403.371 42.296C402.923 41.816 402.699 41.224 402.699 40.52C402.699 39.816 402.923 39.24 403.371 38.792C403.851 38.312 404.443 38.072 405.147 38.072H411.579V31.64C411.579 30.968 411.819 30.392 412.299 29.912C412.811 29.432 413.387 29.192 414.027 29.192C414.763 29.192 415.355 29.432 415.803 29.912C416.251 30.36 416.475 30.936 416.475 31.64V38.072H422.907C423.579 38.072 424.155 38.312 424.635 38.792C425.147 39.272 425.403 39.864 425.403 40.568C425.403 41.24 425.147 41.816 424.635 42.296C424.155 42.776 423.579 43.016 422.907 43.016H416.475V49.448C416.475 50.152 416.251 50.744 415.803 51.224C415.355 51.672 414.763 51.896 414.027 51.896Z" fill="#2F2F2F"/>
                        </svg>
                    </a>
                </div>
            </div>       
            <div>$booksContent</div>       
            <div class="d-flex flex-row justify-content-center">$paginator</div>
        </div>
    </div>
HTML;

$webPage = new WebPage("Bookinator");
$webPage->appendCssUrl("src/style.css");
$webPage->appendJsUrl("src/filters.js");
$webPage->appendContent($content);
$webPage->appendContent(getFooter());

echo $webPage->toHTML();
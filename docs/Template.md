### asset doc TemplateMaker
# Template

## Header
Outputs begin of html. Arg is string.
```
    <html>
        <head>
            ...
        <body>
            ...
```

    TemplateMaker::Header($title);

Optional:
- $title empty => "SITENAME"
- $title not empty => "TITLE"
- $title starts with "+" => "SITENAME : TITLE"

#
## Elemets

### Hero Image
Display Hero Image in header section. Arg is array.
```
    $args = [
        'title' => ""
        ...
    ]
```

    TemplateMaker::HeroImage($args)

Arguments:
- title => display over image
- img => image filename from **/images**
- url => link to author site
- by => author name
- txt => additional description under title

### Download buttons

    TemplateMaker::DownloadBtns($search, $count=3, $skip=TRUE)

- $search => part of filename inside **/data**
Optional:
- $count => display given entries but except first found,
    exp: if "rankings_" will display 1. thru 3. 
    ```
        0. ull_rankings_v8.4.csv
        1. full_rankings_v8.3.csv
        2. full_rankings_v8.2.csv
        3. full_rankings_v8.1.csv
        4. full_rankings_v8.0.csv
        5. full_rankings_v8.0.1.csv
    ```
- $skip => if FALSE also display 0.


        echo TempleteMaker::GetDownload($link,$name)

    - $link => relative path and filename, exp. "data/full_rankings.csv"
    - $name => button's title

### Interview list
Display interview list from **/interviews**. Arg is array.
Image is build like so **/images/filename.png**.
```
    $args = [
        'filename' => [
            'n' => '',
            'b' => ''
        ],
        ...
    ]
```

    TemplateMaker::Interviews($args)

- filename => array key and also filename
- filename[n] => alternative entry title if empty use filename
- filename[b] => blockquote or short description

### Interview entry head
Display \<h1\> entry title with image. Image filename is case lowered $name and then build like above.

    TemplateMaker::InterviewHead($name)

### Hero menu
Display large menu at home page.

    TemplateMaker::HeroMenu($class='style', $skip=TRUE)

Optional args:
- $class => class name but autonumberd (exp. class0, class1 ... class5)
- $skip => if FALSE display menu entry for home/index

#
## Footer
Outputs end of html. Thru args add assets like scripts. Arg is array.
```
    args = [
        'scripts.js',
        'other.css',
        '<script>...</script>'
    ]
```

    TemplateMaker::Footer(args)


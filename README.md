# Create a bootstrap grid layout from a SilverStripe List

Easily create a 12-column grid system from a SilverStripe **List**. The class returns an ArrayList of rows each containing
a items (whatever the List was), the column width, and optional offset (to center-align the last row if it has fewer items
than the specified value).

This was developed for [Bootstrap](http://getbootstrap.com), however can easily be modified to suit any CSS grid system.


## Requirements

- SilverStripe 3+

## Installation

### Install via Composer

You can install it via composer with `composer require axllent/silverstripe-list-to-bootstrap-grid`

### Manually install

Download the latest release from [GitHub](https://github.com/axllent/silverstripe-list-to-bootstrap-grid/releases/latest)
and extract into your web root.

## Basic usage
In your page controller:

```php
<?php

class CategoryPage_Controller extends Controller
{
    public function getProductRows()
    {
        return new ListToBootstrapGrid(
            $this->Products(),  // The list you wish to convert
            $columns = 3,       // Columns per row - must divide into 12!
            $center = true      // Center-align last row if < than $columns
        );
    }    
}
```

Then in your `CategoryPage.ss` template:
```html
<% loop $ProductRows %>
    <div class="row">
        <% loop $Items %>
            <div class="col-sm-{$Up.Width}<% if $First && $Up.Offset %> col-sm-offset-{$Up.Offset}<% end_if %>">
                <h2>$Title</h2>
                ...
            </div>
        <% end_loop %>
    </div>
<% end_loop %>
```
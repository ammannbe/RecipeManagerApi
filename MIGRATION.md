# Migrate from version 5 to 6.0.x

First read this document carefully before you start.

## Before you start

### Keep in mind

-   This version doesn't use any LDAP anymore. This means: **all passwords will be LOST**!

### Important notes

-   Put your application in **maintenance mode** or shut it down completely. No database transactions should be made during the migration process!
-   Copy & Paste the commands one by one, so in case of a problem you can troubleshoot it
-   I recommend to check the database after every command, if it did what it have should
-   Some commands (depending on the amount of table entries) will take some time to migrate
-   For all users the activation date will be set (prio 1: created_at ; prio 2: current timestamp)
-   All users will be referenced now by a foreign key to their authors. The relation will be evaluated through the name
-   If a users currently doesn't have an author, you have to create it manually (see below for more infos)

### Short overview of the process

1. **Backup your application and database**
2. Migrate your database schema and files semi-automatic (this is the point where we kinda destroy it :P)
3. Check for missing data and create it by hand
4. Backup/Save the migrated database
5. Upgrade the application and create a new database
6. Import the migrated data form the old database

### Backup

IMPORTANT: Backup your database **AND** the complete application!
In case of a problem, this will make the restore alot easier :)

```bash
mysqldump -u narrenhaus_user -p narrenhaus_rezepte > /path_to_a_save_place/narrenhaus_rezepte.sql
tar czvf /path_to_a_save_place/cookbook.tar.gz .
```

## Let's go

Start a new tinker session

```bash
php artisan tinker
```

**From here on, you start to edit the database schema!**

What steps are done form now on?

-   Change table and column names
-   Add some new relations
-   Add a lot of `slug` fields
-   Remove some redundant information
-   Move all recipe images to the storage folder

**Important: please follow these instructions step by step, top down**

```php
// Don't forget to import the Blueprint
use Illuminate\Database\Schema\Blueprint;


// Disable FK checks to disable errors
Schema::disableForeignKeyConstraints();


//---- authors ----//
Schema::table('authors', function (Blueprint $table) {
    $table->unsignedBigInteger('user_id')->nullable()->default(null)->after('id');
});

\DB::table('authors')->get()->each(function ($author) {
    $user = \DB::table('users')->select('id')->where('name', $author->name)->first();
    if ($user) {
        \DB::table('authors')
            ->where('id', $author->id)
            ->update(['user_id' => $user->id]);
    }
});


//---- ingredients -> foods ----//
Schema::rename('ingredients', 'foods');

Schema::table('foods', function (Blueprint $table) {
    $table->string('slug', 100)->after('name');
});

\DB::table('foods')->get()->each(function ($food) {
    \DB::table('foods')
        ->where('id', $food->id)
        ->update(['slug' => \Str::slug($food->name)]);
});

Schema::table('foods', function (Blueprint $table) {
    $table->unique('slug');
});


//---- ingredient_details -> ingredients ----//
Schema::rename('ingredient_details', 'ingredients');

Schema::table('ingredients', function (Blueprint $table) {
    $table->renameColumn('ingredient_id', 'food_id');
    $table->renameColumn('ingredient_detail_group_id', 'ingredient_group_id');
    $table->renameColumn('ingredient_detail_id', 'ingredient_id');
});

Schema::table('ingredients', function (Blueprint $table) {
    $table->unique(['recipe_id', 'ingredient_group_id', 'ingredient_id', 'position'], 'ingridient_position_unique');
});


//---- ingredient_detail_groups -> ingredient_groups ----//
Schema::rename('ingredient_detail_groups', 'ingredient_groups');

Schema::table('ingredient_groups', function (Blueprint $table) {
    $table->string('slug', 40)->after('name');
});

\DB::table('ingredient_groups')->get()->each(function ($ingredientGroup) {
    \DB::table('ingredient_groups')
        ->where('id', $ingredientGroup->id)
        ->update(['slug' => \Str::slug($ingredientGroup->name)]);
});

Schema::table('ingredient_groups', function (Blueprint $table) {
    $table->unique(['name', 'recipe_id']);
    $table->unique(['slug', 'recipe_id']);
});


//---- ingredient_detail_prep -> ingredient_ingredient_attribute ----//
Schema::rename('ingredient_detail_prep', 'ingredient_ingredient_attribute');

Schema::table('ingredient_ingredient_attribute', function (Blueprint $table) {
    $table->renameColumn('ingredient_detail_id', 'ingredient_id');
    $table->renameColumn('prep_id', 'ingredient_attribute_id');
});


//---- preps -> ingredient_attributes ----//
Schema::rename('preps', 'ingredient_attributes');

Schema::table('ingredient_attributes', function (Blueprint $table) {
    $table->string('slug', 80)->after('name');
});

\DB::table('ingredient_attributes')->get()->each(function ($ingredientAttribute) {
    \DB::table('ingredient_attributes')
        ->where('id', $ingredientAttribute->id)
        ->update(['slug' => \Str::slug($ingredientAttribute->name)]);
});

Schema::table('ingredient_attributes', function (Blueprint $table) {
    $table->unique('slug');
});


//---- rating_criteria ----//
Schema::table('rating_criteria', function (Blueprint $table) {
    $table->string('slug', 40)->after('name');
});

\DB::table('rating_criteria')->get()->each(function ($ingredientAttribute) {
    \DB::table('rating_criteria')
        ->where('id', $ingredientAttribute->id)
        ->update(['slug' => \Str::slug($ingredientAttribute->name)]);
});

Schema::table('rating_criteria', function (Blueprint $table) {
    $table->unique('slug');
});


//---- recipes ----//
// Thanks to DBAL with his enum issue, we have to do the ALTER TABLE manually
\DB::statement('ALTER TABLE recipes ADD COLUMN cookbook_id BIGINT(20) NULL DEFAULT NULL AFTER user_id');
\DB::statement('ALTER TABLE recipes CHANGE photo photos LONGTEXT');

$storagePathRecipeImages = storage_path('app/images/recipes');
mkdir(storage_path('app/images'));
mkdir($storagePathRecipeImages);
\DB::table('recipes')->whereNotNull('photos')->get()->each(function ($recipe) use ($storagePathRecipeImages) {
    $oldPath = public_path('images/recipes');
    $newPath = "{$storagePathRecipeImages}/{$recipe->id}";
    if (!file_exists($newPath)) {
        mkdir($newPath);
    }
    copy("{$oldPath}/{$recipe->photos}", "{$newPath}/{$recipe->photos}");

    \DB::table('recipes')
        ->where('id', $recipe->id)
        ->update(['photos' => [$recipe->photos]]);
});

Schema::table('recipes', function (Blueprint $table) {
    $table->unique(['name', 'cookbook_id']);
    $table->unique(['slug', 'cookbook_id']);
});


//---- units ----//
Schema::table('units', function (Blueprint $table) {
    $table->string('slug', 40)->after('name');
});

\DB::table('units')->get()->each(function ($unit) {
    \DB::table('units')
        ->where('id', $unit->id)
        ->update(['slug' => \Str::slug($unit->name)]);
});

Schema::table('units', function (Blueprint $table) {
    $table->unique('slug');
});


//---- users ----//
Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('name');
    $table->dropColumn('username');
    $table->timestamp('email_verified_at')->nullable();
    $table->boolean('admin')->default(0);
});

\DB::table('users')->get()->each(function ($user) {
    $admin = $user->user_type == 'admin';

    \DB::table('users')
        ->where('id', $user->id)
        ->update([
            'email_verified_at' => $user->created_at ?? now(),
            'admin' => $user->user_type == 'admin',
        ]);
});

Schema::table('users', function (Blueprint $table) {
    $table->dropColumn('user_type');
});

```

Now we make sure that every user has his author
This command will dump'n'die after each error

```php
\DB::table('users')->get()->each(function ($user) {
    $hasAuthor = \DB::table('authors')
        ->where('user_id', $user->id)
        ->exists();

    if (!$hasAuthor) {
        dd($user);
    }
});
```

If one or more are missing, add them manually:

```php
$name = 'Max Mustermann'; // CHANGE THIS VARIABLE
$userId = 1; // CHANGE THIS VARIABLE
\DB::table('authors')->insert([
    'name' => $name,
    'slug' => \Str::slug($name),
    'user_id' => $userId
]);
```

Every recipe needs one author

```php
\DB::table('recipes')->whereNull('author_id')->get()->each(function ($recipe) {
    $user = \DB::table('users')->where('id', $recipe->user_id)->first();
    $author = \DB::table('authors')->where('user_id', $user->id)->first();

    \DB::table('recipes')
        ->where('id', $recipe->id)
        ->update(['author_id' => $author->id]);
});
```

Now it's time to dump our migrated database. Make sure you also copy the arguments.
What they do?

- `--skip-add-drop-table`: remove `DROP TABLE` statements
- `--complete-insert`: add complete insert statement (not just the values but also the columns)
- `--no-create-info`: do not recreate tables
- `--compact`: skip comments and locks, make the import faster, and more

```bash
mysqldump -u narrenhaus_user -p narrenhaus_rezepte --skip-add-drop-table --complete-insert --no-create-info --compact > narrenhaus_rezepte.migrated.sql
```

Update the application to version **6.0.x** e.g. via git to **6.0.0**:

```bash
git checkout 6.0.0
git pull
```

-   Checkout the README.md of this version on how to install
-   IMPORTANT: make a fresh migration of the database with `php artisan migrate:fresh`

-   After you've installed everything, import the data back into the fresh database

```bash
# Disable Foreign key checks temporarily
sed -i '1s/^/SET FOREIGN_KEY_CHECKS=0;\n /' narrenhaus_rezepte.migrated.sql
# Import data
mysql -u narrenhaus_user -p narrenhaus_rezepte < narrenhaus_rezepte.migrated.sql
```

Make sure everything worked correctly! Startup your application and test a little bit.

----

And you're done!

Is there a newer version? Now is the time to update.

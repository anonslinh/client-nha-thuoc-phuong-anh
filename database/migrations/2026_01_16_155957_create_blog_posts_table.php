<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('blog_posts', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')
                ->nullable()
                ->constrained('blog_categories')
                ->nullOnDelete()
                ->index();

            $table->string('title', 255);
            $table->string('slug', 191)->unique();
            $table->string('excerpt', 500)->nullable();
            $table->longText('content');

            $table->string('thumbnail_url', 500)->nullable();
            $table->string('image_url', 500)->nullable();

            $table->string('author_name', 120)->nullable();

            // SEO fields
            $table->string('seo_title', 255)->nullable();
            $table->string('meta_description', 500)->nullable();
            $table->string('meta_keywords', 500)->nullable();

            $table->unsignedBigInteger('view_count')->default(0);

            $table->boolean('is_published')->default(false)->index();
            $table->timestamp('published_at')->nullable()->index();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blog_posts');
    }
};

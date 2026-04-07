<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('empresa_id')->constrained('empresas')->onDelete('cascade');
            $table->string('nombre');
            $table->text('descripcion')->nullable();
            $table->decimal('precio', 10, 2);
            $table->unsignedInteger('cantidad')->default(0);
            $table->boolean('activo')->default(true);
            $table->boolean('es_basico')->default(true);
            $table->unsignedInteger('orden')->default(0);
            $table->timestamps();
        });

        if (Schema::hasTable('carrito')) {
            try {
                DB::statement('ALTER TABLE carrito DROP INDEX carrito_user_servicio_unique');
            } catch (\Throwable $e) {
                // índice con otro nombre o ya eliminado
            }

            DB::statement('ALTER TABLE carrito MODIFY servicio_id BIGINT UNSIGNED NULL');

            Schema::table('carrito', function (Blueprint $table) {
                if (!Schema::hasColumn('carrito', 'tipo')) {
                    $table->enum('tipo', ['servicio', 'producto'])->default('servicio')->after('user_id');
                }
                if (!Schema::hasColumn('carrito', 'producto_id')) {
                    $table->foreignId('producto_id')->nullable()->after('servicio_id')
                        ->constrained('productos')->onDelete('cascade');
                }
                if (!Schema::hasColumn('carrito', 'cantidad')) {
                    $table->unsignedInteger('cantidad')->default(1)->after('producto_id');
                }
            });
        }

        if (Schema::hasTable('orden_items')) {
            try {
                DB::statement('ALTER TABLE orden_items DROP FOREIGN KEY orden_items_servicio_id_foreign');
            } catch (\Throwable $e) {
            }

            DB::statement('ALTER TABLE orden_items MODIFY servicio_id BIGINT UNSIGNED NULL');

            Schema::table('orden_items', function (Blueprint $table) {
                if (!Schema::hasColumn('orden_items', 'tipo')) {
                    $table->enum('tipo', ['servicio', 'producto'])->default('servicio')->after('orden_id');
                }
                if (!Schema::hasColumn('orden_items', 'producto_id')) {
                    $table->foreignId('producto_id')->nullable()->after('servicio_id')
                        ->constrained('productos')->nullOnDelete();
                }
                if (!Schema::hasColumn('orden_items', 'cantidad')) {
                    $table->unsignedInteger('cantidad')->default(1)->after('precio');
                }
            });

            try {
                DB::statement('ALTER TABLE orden_items ADD CONSTRAINT orden_items_servicio_id_foreign FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE SET NULL');
            } catch (\Throwable $e) {
            }
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orden_items')) {
            Schema::table('orden_items', function (Blueprint $table) {
                if (Schema::hasColumn('orden_items', 'cantidad')) {
                    $table->dropColumn('cantidad');
                }
                if (Schema::hasColumn('orden_items', 'producto_id')) {
                    $table->dropForeign(['producto_id']);
                    $table->dropColumn('producto_id');
                }
                if (Schema::hasColumn('orden_items', 'tipo')) {
                    $table->dropColumn('tipo');
                }
            });
            DB::statement('ALTER TABLE orden_items MODIFY servicio_id BIGINT UNSIGNED NOT NULL');
            try {
                DB::statement('ALTER TABLE orden_items ADD CONSTRAINT orden_items_servicio_id_foreign FOREIGN KEY (servicio_id) REFERENCES servicios(id) ON DELETE CASCADE');
            } catch (\Throwable $e) {
            }
        }

        if (Schema::hasTable('carrito')) {
            Schema::table('carrito', function (Blueprint $table) {
                if (Schema::hasColumn('carrito', 'cantidad')) {
                    $table->dropColumn('cantidad');
                }
                if (Schema::hasColumn('carrito', 'producto_id')) {
                    $table->dropForeign(['producto_id']);
                    $table->dropColumn('producto_id');
                }
                if (Schema::hasColumn('carrito', 'tipo')) {
                    $table->dropColumn('tipo');
                }
            });
            DB::statement('ALTER TABLE carrito MODIFY servicio_id BIGINT UNSIGNED NOT NULL');
            try {
                DB::statement('ALTER TABLE carrito ADD UNIQUE KEY carrito_user_servicio_unique (user_id, servicio_id)');
            } catch (\Throwable $e) {
            }
        }

        Schema::dropIfExists('productos');
    }
};

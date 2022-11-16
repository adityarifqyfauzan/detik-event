# DETIK TICKET EVENT

Membuat Restful API dan CLI ticket generator.

## Installation

Siapkan configurasi database pada file .env

Untuk init database, jalankan command berikut:

```python
php init.php
```

Untuk migration table, terdapat 2 cara, yaitu:

#### 1. Menggunakan sql-migrate

```python
sql-migrate up
```

#### 2. Menggunakan perintah php

```python
php migration.php
```

Setelah proses migration berhasil, jalankan seeder untuk membuat data dummy (optional). Untuk menjalankan seeder, jalankan perintah berikut:

```python
php seeder.php
```

## Generate Bulk Ticket

Untuk membuat bulk tiket, dapat menjalankan perintah berikut:

```python
php generate-ticket.php event_id=[id] total=[total]
```

## Usage

Jalankan local server dengan command berikut:

```python
php -S 127.0.0.1:port -t public
```
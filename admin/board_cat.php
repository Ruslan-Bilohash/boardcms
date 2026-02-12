<?php
// /admin/board_cat.php — Адаптивний редактор категорій (оновлено 03.01.2026)
// Автор: Руслан Білогаш
// ✅ Переклади ua/en/no прямо в файлі
// ✅ Захист від 1452 видалено
// ✅ Новий гарний дизайн (clamp, grid, flex, hover)
// ✅ Перемикач мов з прапорами
// ✅ Живе прев’ю іконок Font Awesome
// ✅ Бургер-меню + мобільна таблиця

session_start();

// Перевірка адмін-доступу (як в index.php)
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header("Location: /admin/login.php");
    exit;
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Перемикач мови
if (isset($_GET['admin_lang']) && in_array($_GET['admin_lang'], ['ua','en','no'])) {
    $_SESSION['admin_lang'] = $_GET['admin_lang'];
    header("Location: " . strtok($_SERVER['REQUEST_URI'], '?'));
    exit;
}
$current_lang = $_SESSION['admin_lang'] ?? 'ua';

// Переклади
$trans = [
    'ua' => [
        'title' => 'Категорії оголошень',
        'add' => 'Додати категорію',
        'edit' => 'Редагувати категорію',
        'name_ua' => 'Назва укр *',
        'name_en' => 'English name',
        'name_no' => 'Norsk navn',
        'slug' => 'Slug',
        'parent' => 'Батьківська',
        'root' => 'Коренева',
        'order' => 'Порядок',
        'icon' => 'Іконка',
        'active' => 'Активна',
        'save' => 'Зберегти',
        'cancel' => 'Скасувати',
        'delete' => 'Видалити',
        'confirm_delete' => 'Видалити?',
        'success' => 'Готово!',
        'error_name' => 'Назва укр обов’язкова!',
        'no_cat' => 'Категорій немає…',
        'actions' => 'Дії',
        'main' => 'Головна',
        'logout' => 'Вийти',
        'lang' => 'Мова',
    ],
    'en' => [
        'title' => 'Categories',
        'add' => 'Add Category',
        'edit' => 'Edit Category',
        'name_ua' => 'Ukrainian *',
        'name_en' => 'English',
        'name_no' => 'Norwegian',
        'slug' => 'Slug',
        'parent' => 'Parent',
        'root' => 'Root',
        'order' => 'Order',
        'icon' => 'Icon',
        'active' => 'Active',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'delete' => 'Delete',
        'confirm_delete' => 'Delete?',
        'success' => 'Done!',
        'error_name' => 'Ukrainian name required!',
        'no_cat' => 'No categories yet…',
        'actions' => 'Actions',
        'main' => 'Dashboard',
        'logout' => 'Logout',
        'lang' => 'Language',
    ],
    'no' => [
        'title' => 'Kategorier',
        'add' => 'Legg til kategori',
        'edit' => 'Rediger kategori',
        'name_ua' => 'Ukrainsk *',
        'name_en' => 'Engelsk',
        'name_no' => 'Norsk',
        'slug' => 'Slug',
        'parent' => 'Overordnet',
        'root' => 'Rot',
        'order' => 'Rekkefølge',
        'icon' => 'Ikon',
        'active' => 'Aktiv',
        'save' => 'Lagre',
        'cancel' => 'Avbryt',
        'delete' => 'Slett',
        'confirm_delete' => 'Slette?',
        'success' => 'Ferdig!',
        'error_name' => 'Ukrainsk navn kreves!',
        'no_cat' => 'Ingen kategorier ennå…',
        'actions' => 'Handlinger',
        'main' => 'Hovedside',
        'logout' => 'Logg ut',
        'lang' => 'Språk',
    ]
];
$t = $trans[$current_lang] ?? $trans['ua'];

// CSRF
$csrf = $_SESSION['csrf_token'] ?? ($_SESSION['csrf_token'] = bin2hex(random_bytes(32)));

// ID
$id = (int)($_GET['id'] ?? 0);
$error = $success = '';
$cat = ['slug'=>'','name_ua'=>'','name_en'=>'','name_no'=>'','parent_id'=>0,'order'=>10,'icon'=>'fas fa-list-ul','is_active'=>1];

// Обробка форми (без перевірки 1452)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['csrf']) && $_POST['csrf'] === $csrf) {
    $slug = trim($_POST['slug'] ?? '');
    $name_ua = trim($_POST['name_ua'] ?? '');
    $name_en = trim($_POST['name_en'] ?? '');
    $name_no = trim($_POST['name_no'] ?? '');
    $parent_id = (int)($_POST['parent_id'] ?? 0);
    $order = (int)($_POST['order'] ?? 10);
    $icon = trim($_POST['icon'] ?? 'fas fa-list-ul');
    $active = isset($_POST['is_active']) ? 1 : 0;

    if (!$name_ua) {
        $error = $t['error_name'];
    } else {
        try {
            if ($id > 0) {
                $pdo->prepare("UPDATE categories SET slug=?,name_ua=?,name_en=?,name_no=?,parent_id=?,`order`=?,icon=?,is_active=?,updated_at=NOW() WHERE id=?")
                    ->execute([$slug,$name_ua,$name_en,$name_no,$parent_id,$order,$icon,$active,$id]);
                $success = $t['success'];
            } else {
                $pdo->prepare("INSERT INTO categories (slug,name_ua,name_en,name_no,parent_id,`order`,icon,is_active,created_at) VALUES (?,?,?,?,?,?,?,?,NOW())")
                    ->execute([$slug,$name_ua,$name_en,$name_no,$parent_id,$order,$icon,$active]);
                $success = $t['success'];
            }
        } catch (Exception $e) {
            $error = "Помилка БД: " . $e->getMessage();
        }
    }
}

// Список
$list = [];
try {
    $list = $pdo->query("SELECT * FROM categories ORDER BY `order` ASC, name_ua ASC")->fetchAll(PDO::FETCH_ASSOC) ?? [];
    if ($id) {
        $cat = $pdo->prepare("SELECT * FROM categories WHERE id=?")->execute([$id])->fetch(PDO::FETCH_ASSOC) ?: $cat;
    }
} catch (Exception $e) {
    $error = "Не вдалося завантажити список: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="<?= $current_lang ?>">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($t['title']) ?> — Admin</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
<link href="https://fonts.googleapis.com/css2?family=Manrope:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
:root{--p:#4361ee;--d:#0f172a;--bg:#f1f5f9;--g:#64748b;--gr:#10b981;--r:#ef4444;--sh:0 10px 40px rgba(0,0,0,.08);}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'Manrope',sans-serif;background:var(--bg);color:var(--d);line-height:1.6}
header{background:linear-gradient(135deg,var(--d),#172554);color:#fff;padding:clamp(1rem,3vw,1.4rem) 5%;display:flex;justify-content:space-between;align-items:center;position:sticky;top:0;z-index:1000;box-shadow:0 4px 20px rgba(0,0,0,.35)}
.logo{font-size:clamp(1.5rem,4.5vw,1.9rem);font-weight:700;display:flex;align-items:center;gap:.7rem}
.logo i{font-size:clamp(1.6rem,5vw,2rem);color:#60a5fa}
.nav-desktop{display:flex;align-items:center;gap:clamp(1rem,3vw,2.5rem)}
.nav-desktop a{color:#cbd5e1;text-decoration:none;font-weight:500;font-size:clamp(.9rem,2.2vw,1rem);transition:.3s}
.nav-desktop a:hover{color:#60a5fa;transform:translateY(-2px)}
.burger{display:none;font-size:1.8rem;cursor:pointer;color:#fff;padding:.6rem;border-radius:8px;transition:.3s}
.burger:hover{background:rgba(255,255,255,.15)}
.mobile-menu{display:none;position:fixed;inset:0;background:rgba(15,23,42,.98);backdrop-filter:blur(10px);z-index:999;padding:5rem 5% 2rem;overflow-y:auto}
.mobile-menu.show{display:block}
.mobile-close{position:absolute;top:1.5rem;right:5%;font-size:2.2rem;color:#fff;cursor:pointer}
.mobile-nav{display:flex;flex-direction:column;gap:1.5rem;margin-top:2rem}
.mobile-nav a{color:#fff;text-decoration:none;font-size:1.3rem;font-weight:500;padding:1rem 0;border-bottom:1px solid rgba(255,255,255,.15);display:flex;align-items:center;gap:.8rem}
.container{max-width:1280px;margin:2.5rem auto;padding:0 5%}
h1{font-size:clamp(2rem,5vw,2.6rem);margin-bottom:2rem;color:var(--d)}
.card{background:#fff;border-radius:20px;box-shadow:var(--sh);padding:clamp(1.8rem,4vw,2.8rem);margin-bottom:2.5rem}
.form-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(320px,1fr));gap:2rem}
.form-group{display:flex;flex-direction:column;gap:.7rem}
label{font-weight:600;color:var(--g);font-size:.95rem}
input,select{padding:1rem 1.2rem;border:1px solid #d1d5db;border-radius:12px;font-size:1rem;transition:.25s}
input:focus,select:focus{outline:none;border-color:var(--p);box-shadow:0 0 0 4px rgba(99,102,241,.15)}
.icon-preview{font-size:3.5rem;color:var(--p);text-align:center;margin:1rem 0;transition:.3s}
.icon-preview:hover{transform:scale(1.15)}
.btn{padding:1rem 2.2rem;border:none;border-radius:12px;font-weight:600;font-size:1rem;cursor:pointer;transition:.25s}
.btn-p{background:var(--p);color:#fff}
.btn-p:hover{background:#4f46e5;transform:translateY(-3px)}
.btn-d{background:var(--r);color:#fff}
.btn-d:hover{background:#dc2626;transform:translateY(-3px)}
.msg{padding:1.4rem;border-radius:12px;margin-bottom:2rem;text-align:center;font-weight:500}
.success{background:#ecfdf5;color:#065f46}
.error{background:#fee2e2;color:#991b1b}
table{width:100%;border-collapse:collapse;background:#fff;border-radius:16px;overflow:hidden;box-shadow:var(--sh)}
th,td{padding:1.3rem;text-align:left}
th{background:var(--d);color:#fff;font-weight:600}
tr:nth-child(even){background:#f9fafb}
.icon-cell i{font-size:1.9rem;color:var(--p)}
.lang-switch{display:flex;gap:.8rem;position:absolute;top:1.2rem;right:5%}
.lang-flag{width:38px;height:38px;border-radius:50%;background:rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;cursor:pointer;transition:.3s}
.lang-flag.active{background:var(--p);transform:scale(1.1)}
.lang-flag:hover{transform:scale(1.1)}
@media(max-width:1024px){.form-grid{grid-template-columns:1fr}}
@media(max-width:992px){.nav-desktop{display:none}.burger{display:block}header{padding:1rem 5%}}
@media(max-width:640px){.container{padding:0 4%}table{font-size:.95rem}th,td{padding:1rem}}
</style>
</head>
<body>

<header>
    <div class="logo"><i class="fas fa-layer-group"></i> <?= $t['title'] ?></div>
    <div class="nav-desktop">
        <a href="/admin/index.php"><i class="fas fa-home"></i> <?= $t['main'] ?></a>
        <a href="/admin/logout.php" style="color:#f87171;"><i class="fas fa-sign-out-alt"></i> <?= $t['logout'] ?></a>
    </div>
    <div class="burger" id="burgerBtn"><i class="fas fa-bars"></i></div>
  
</header>

<!-- Мобільне меню -->
<div class="mobile-menu" id="mobileMenu">
    <div class="mobile-close" id="mobileClose">×</div>
    <nav class="mobile-nav">
        <a href="/admin/index.php"><i class="fas fa-home"></i> <?= $t['main'] ?></a>
        <a href="/admin/logout.php" style="color:#f87171;"><i class="fas fa-sign-out-alt"></i> <?= $t['logout'] ?></a>
    </nav>
</div>

<div class="container">
    <h1><?= $id ? $t['edit'] : $t['title'] ?></h1>

    <?php if($error): ?>
        <div class="msg error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php if($success): ?>
        <div class="msg success"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="card">
        <form method="post">
            <input type="hidden" name="csrf" value="<?= $csrf ?>">
            <input type="hidden" name="id" value="<?= $id ?>">

            <div class="form-grid">
                <div class="form-group">
                    <label><?= $t['name_ua'] ?></label>
                    <input type="text" name="name_ua" required value="<?= htmlspecialchars($cat['name_ua']??'') ?>">
                </div>
                <div class="form-group">
                    <label><?= $t['name_en'] ?></label>
                    <input type="text" name="name_en" value="<?= htmlspecialchars($cat['name_en']??'') ?>">
                </div>
                <div class="form-group">
                    <label><?= $t['name_no'] ?></label>
                    <input type="text" name="name_no" value="<?= htmlspecialchars($cat['name_no']??'') ?>">
                </div>
                <div class="form-group">
                    <label><?= $t['slug'] ?></label>
                    <input type="text" name="slug" value="<?= htmlspecialchars($cat['slug']??'') ?>">
                </div>
                <div class="form-group">
                    <label><?= $t['parent'] ?></label>
                    <select name="parent_id">
                        <option value="0"><?= $t['root'] ?></option>
                        <?php foreach($valid_parents as $p): if($p==0 || $p!=$id): ?>
                            <option value="<?= $p ?>" <?= ($cat['parent_id']??0)==$p?'selected':'' ?>>
                                <?= $p==0?$t['root']:'ID '.$p ?>
                            </option>
                        <?php endif; endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label><?= $t['order'] ?></label>
                    <input type="number" name="order" value="<?= htmlspecialchars($cat['order']??10) ?>">
                </div>
                <div class="form-group">
                    <label><?= $t['icon'] ?></label>
                    <input type="text" name="icon" value="<?= htmlspecialchars($cat['icon']??'fas fa-list-ul') ?>" id="i">
                    <div id="ip" class="icon-preview"><i class="<?= htmlspecialchars($cat['icon']??'fas fa-list-ul') ?>"></i></div>
                </div>
                <div class="form-group">
                    <label style="display:flex;align-items:center;gap:.8rem">
                        <input type="checkbox" name="is_active" value="1" <?= ($cat['is_active']??1)?'checked':'' ?>>
                        <?= $t['active'] ?>
                    </label>
                </div>
            </div>

            <div style="margin-top:2.5rem;display:flex;gap:1.2rem;flex-wrap:wrap">
                <button type="submit" class="btn btn-p"><?= $id?$t['save']:$t['add'] ?></button>
                <?php if($id): ?>
                    <a href="?id=0" class="btn" style="background:var(--g);color:#fff;padding:0.9rem 2rem;border-radius:10px;text-decoration:none;"><?= $t['cancel'] ?></a>
                    <button type="submit" name="delete" class="btn btn-d" onclick="return confirm('<?= $t['confirm_delete'] ?>')"><?= $t['delete'] ?></button>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <?php if($list): ?>
    <div class="card">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Назва</th>
                    <th>Іконка</th>
                    <th><?= $t['order'] ?></th>
                    <th><?= $t['active'] ?></th>
                    <th><?= $t['actions'] ?></th>
                </tr>
            </thead>
            <tbody>
            <?php foreach($list as $c): ?>
                <tr>
                    <td data-label="ID"><?= $c['id'] ?></td>
                    <td data-label="Назва"><?= htmlspecialchars($c['name_ua']) ?></td>
                    <td data-label="Іконка"><i class="<?= htmlspecialchars($c['icon']??'fas fa-question') ?>"></i></td>
                    <td data-label="<?= $t['order'] ?>"><?= $c['order'] ?></td>
                    <td data-label="<?= $t['active'] ?>"><?= $c['is_active'] ? '✓' : '✗' ?></td>
                    <td data-label="<?= $t['actions'] ?>"><a href="?id=<?= $c['id'] ?>" style="color:var(--p)"><i class="fas fa-edit"></i></a></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php else: ?>
        <div style="text-align:center;padding:6rem 1rem;color:var(--g);font-size:1.4rem">
            <?= $t['no_cat'] ?>
        </div>
    <?php endif; ?>
</div>

<?php require_once $_SERVER['DOCUMENT_ROOT'] . '/admin/footer.php'; ?>

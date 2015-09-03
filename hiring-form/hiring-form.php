<?
/**
 * @package Hiring Form
 */
/*
 * Plugin Name: Hiring Form
 * Plugin URI: http://lodyr.com/
 * Description: Плагин создает шорткод [hiring_form] для вывода формы.
 * Version: 1.0.0
 * Author: Stanislav Shvaiko
 * Author URI: http://yan.total.all@gmail.com/
 * License: GPL2
 */

add_action('wp_enqueue_scripts', 'hf_styles');
add_action('wp_enqueue_scripts', 'hf_scripts');
add_shortcode( 'hiring_form', 'hf_hiring_form' );
add_action( 'init', 'hf_submit' );
add_action('admin_menu', 'hf_plugin_settings');

/**
 * Stylesheets
 */
function hf_styles() {
    wp_register_style('hf_style', plugins_url('assets/css/main.css', __FILE__));
    wp_enqueue_style('hf_style');
}


/**
 * Scripts
 */
function hf_scripts() {
    wp_enqueue_script('jquery');
    wp_register_script('hf_js', plugins_url('assets/js/main.js', __FILE__), array("jquery"));
    wp_enqueue_script('hf_js');
}

/**
 * Shortcode
 */
function hf_hiring_form () {
    $skills = get_option('hf_skills');
    $skills = explode(PHP_EOL, $skills);
    $count = ceil(count($skills)/3);
    $i=0;
    $skills_html = '';
    foreach (array_chunk($skills, $count, true) as $array)
    {
        $skills_html .= '<ul>';
        foreach($array as $value)
        {
            $skills_html .= '<li>
                       <input type="checkbox" class="stylized stylized--checkbox" id="skill_'.$i.'" name="data[skills][]" value="'.$value.'">
                       <label for="skill_'.$i.'">'.$value.'</label>
                  </li>';
            $i++;
        }
        $skills_html .= '</ul>';
    }
    $html = '<div class="hf_wrapper">
            <div class="hf_header">
                <span class="header__logo"></span>
            </div>
            <div class="hf_content">
                <span class="hf_h1">Анкета</span>
                <div class="content__form">
                    <form action="" method="POST">
                        <input type="hidden" name="submitted" value="1">
                        <div class="text-items">
                            <div class="text-items__item">
                                <div class="text-item__label">Ваше ФИО:</div>
                                <div class="text-item__input">
                                    <input type="text" name="data[fio]" value="" class="form__input__text" required>
                                </div>
                            </div>
                            <div class="text-items__item">
                                <div class="text-item__label">Год рождения:</div>
                                <div class="text-item__input">
                                    <input type="text" name="data[year]" value="" class="form__input__text" required>
                                </div>
                            </div>
                            <div class="text-items__item">
                                <div class="text-item__label">Место жительства:</div>
                                <div class="text-item__input">
                                    <input type="text" name="data[place]" value="" class="form__input__text" required>
                                </div>
                            </div>
                            <div class="text-items__item">
                                <div class="text-item__label text-item__label--small">Skype:</div>
                                <div class="text-item__input text-item__input-small">
                                    <input type="text" name="data[skype]" value="" class="form__input__text" required>
                                </div>
                            </div>
                            <div class="text-items__item">
                                <div class="text-item__label text-item__label--small">Почта:</div>
                                <div class="text-item__input text-item__input-small">
                                    <input type="email" name="data[email]" value="" class="form__input__text" required>
                                </div>
                            </div>
                            <div class="text-items__item text-items__item--radio">
                                <div class="text-item__label text-item__label--radio">О вакансии узнали на сайте <a href="http://moykrug.ru/" target="_blank">moykrug.ru</a></div>
                                <div class="text-item__input text-item__input--radio">
                                    <input type="radio" class="stylized stylized--radio" id="yes" name="data[moukrug]" value="yes" checked>
                                    <label for="yes">Да</label>
                                    <input type="radio" class="stylized stylized--radio" id="no" name="data[moukrug]" value="no">
                                    <label for="no">Нет</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-items text-items--skills">
                            <span class="skills__heading">Навыки</span>
                            '.$skills_html.'
                        </div>
                        <div class="text-items text-items--slider">
                            <span class="skills__heading skills__heading--slider">Уровень знания JavaScript</span>
                            <div class="slider__block">
                                <div class="slider__block--line sliderjs">
                                    <input type="hidden" name="data[js]" value="82">
                                    <div class="slider__block--value" style="width: 82%;"></div>
                                </div>
                                <div class="slider__labels">
                                    <label data-skill="0" class="level_0">Не знаю</label>
                                    <label data-skill="33" class="level_1">Использую готовые решения</label>
                                    <label data-skill="66" class="level_2">Использую готовые решения<br>и умею их переделывать</label>
                                    <label data-skill="100" class="level_3">Пишу сложные скрипты</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-items text-items--slider">
                            <span class="skills__heading skills__heading--slider">Уровень знания PHP</span>
                            <div class="slider__block">
                                <div class="slider__block--line sliderjs">
                                    <input type="hidden" name="data[php]" value="66">
                                    <div class="slider__block--value slider__block__value--php" style="width: 66%;"></div>
                                </div>
                                <div class="slider__labels">
                                    <label data-skill="0" class="level_0">Не знаю</label>
                                    <label data-skill="33" class="level_1">Базовые знания</label>
                                    <label data-skill="66" class="level_2">Хороший уровень знаний</label>
                                    <label data-skill="100" class="level_3">Отличный уровень</label>
                                </div>
                            </div>
                        </div>
                        <div class="text-items text-items__repo">
                            <div class="text-items__item">
                                <div class="text-item__label">Ссылка на репозиторий:</div>
                                <div class="text-item__input">
                                    <input type="text" name="data[rep]" value="" class="form__input__text">
                                </div>
                                <p>Или на портфолио (если есть)</p>
                            </div>
                        </div>
                        <div class="form__submit">
                            <input type="submit" value="Отправить">
                        </div>
                    </form>
                </div>
            </div>
        </div>';
    return $html;
}


/**
 * Send email
 */
function hf_submit()
{
    if (isset($_POST['submitted']) && '1' == $_POST['submitted']) {
        /**
         * тут нужно добавить проверки на правильность заполнения
         *валидацию полей
         *русификацию названий
         *но думаю и так будет понятно, подойду ли я вам ;)
         */
        $message = '';
        foreach($_POST["data"] as $key=>$var) {
            if($key == "skills")
                $var = implode(", ", $var);
            $message .= $key.': '.$var."\n";
        }
        $email = get_option('hf_email');
        $sent = wp_mail($email, "Hiring form", $message);
        if($sent) {
            //thx...
        }
        else {
            //error...
        }
    }
}

/**
 * Settings page
 */
function hf_plugin_settings()
{
    add_options_page('Hires Form settings', 'Hires Form settings', 'administrator', 'hf_settings', 'hf_display_settings');
}

function hf_display_settings()
{
    $default_skills = 'Методология БЭМ
    Использую GRUNT
    Использую GULP
    SASS
    LESS
    CoffeeScript
    Angular
    jQuery
    Использую Avocode
    Адаптивная верстка
    Использую Git
    PHP
    Хороший английский
    Знаю Wordpress
    Опыт с Woocommerce
    Пишу плагины WP';

    $email = (get_option('hf_email') != '') ? get_option('hf_email') : '';
    $skills = (get_option('hf_skills') != '') ? get_option('hf_skills') : $default_skills;
    if(get_option('hf_skills') == '') {
        update_option('hf_skills', $default_skills);
    }
    $html = '<div class="wrap">
            <style>
            .item {
                margin-top: 10px;
            }
            </style>
            <form method="post" name="options" action="options.php">

            <h2>Settings</h2>' . wp_nonce_field('update-options') . '

            <div class="item"><label>E-mail</label><br><input type="email" name="hf_email" value="' . $email . '" required></div>
            <div class="item"><label>Skills</label><br><textarea name="hf_skills" rows="10" required>' . $skills . '</textarea></div>

            <p class="submit">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="page_options" value="hf_email,hf_skills">
                <input type="submit" name="Submit" value="Update">
            </p>
            </form>

        </div>';
    echo $html;
}

?>
<style>
    /* Core styles/functionality */
    .tab {
        position: relative;
        border-top: 1px solid #ccc;
    }

    .tab input {
        position: absolute;
        opacity: 0;
        z-index: -1;
    }

    .tab__content {
        max-height: 0;
        overflow: hidden;
        transition: all 0.35s;
    }

    .tab input:checked ~ .tab__content {
        max-height: 10rem;
    }

    /* Visual styles */
    .accordion {
        color: var(--theme);
        overflow: hidden;
    }

    .tab__label,
    .tab__close {
        display: flex;
        color: black;
        background: var(--theme);
        cursor: pointer;
    }

    .tab__label {
        justify-content: space-between;
        padding: 1rem;
    }

    .tab__label::after {
        content: "\276F";
        /*content: "	\002B";*/
        width: 1em;
        height: 1em;
        text-align: center;
        transform: rotate(90deg);
        transition: all 0.35s;
    }

    .tab input:checked + .tab__label::after {
        transform: rotate(270deg);
    }

    .tab__content p {
        margin: 0;
        padding: 1rem;
    }

    .tab__close {
        justify-content: flex-end;
        padding: 0.5rem 1rem;
        font-size: 0.75rem;
    }

    .accordion--radio {
        --theme: var(--secondary);
    }

    /* Arrow animation */
    .tab input:not(:checked) + .tab__label:hover::after {
        animation: bounce .5s infinite;
    }

    @keyframes bounce {
        25% {
            transform: rotate(90deg) translate(.25rem);
        }
        75% {
            transform: rotate(90deg) translate(-.25rem);
        }
    }

</style>
<h2 style="text-align: center;"><b><span style="font-size: 42pt; font-family: &quot;Arial Black&quot;, Gadget;">Правила начисления и использования бонусов</span></b> </h2>
<div class="container">
 <section class="accordion">
	<div class="tab">
 <input type="checkbox" name="accordion-1" id="cb1" > <label for="cb1" class="tab__label"> <span style="font-family: &quot;Arial Black&quot;, Gadget; font-size: 22pt;">Начисление баллов</span> </label>
		<div class="tab__content">
			<p>
				 Участники программы еженедельно получают баллы за выполнение установленных активностей
			</p>
		</div>
	</div>
	<div class="tab">
 <input type="checkbox" name="accordion-1" id="cb2"><span style="font-family: &quot;Arial Black&quot;, Gadget; font-size: 22pt;"> </span><label for="cb2" class="tab__label"><span style="font-family: &quot;Arial Black&quot;, Gadget; font-size: 22pt;">
		Использование баллов</span> </label>
		<div class="tab__content">
			<p>
				 После завершения квартала все накопленные баллы сотрудника суммируются, открывая доступ к специальному магазину бонусов, где их можно обменять на выбранную продукцию.
			</p>
		</div>
	</div>
	<div class="tab">
 <input type="checkbox" name="accordion-1" id="cb3"> <label for="cb3" class="tab__label"> <span style="font-family: &quot;Arial Black&quot;, Gadget; font-size: 22pt;">Использование баллов</span> </label>
		<div class="tab__content">
			<p>
				 Неиспользованные баллы, кроме специально отмеченных несгораемых баллов за корпоративное обучение, аннулируются по истечении квартала
			</p>
		</div>
	</div>
 </section>
</div>
 <br>
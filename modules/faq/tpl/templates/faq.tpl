{foreach item=cat from=$faq.cats}
  <font size="+1"><b>{$cat.name}</b></font><br />
  {foreach item=question from=$cat.questions}
    <a href="{$smarty.server.SCRIPT_NAME}/faq/eventHandler=view/faqID={$question.contentID}">{$question.question}</a>  <br />
  {/foreach}
  <br />
{/foreach}

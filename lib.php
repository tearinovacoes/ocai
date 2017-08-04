<?php

  function getOcaiResults() {
      $results = array();

      $results["dimensoes"] = ORM::for_table('item')->find_array();

      $str="
        select
          subitem.org_culture as org_culture,
          round(avg(response.subitem_actual),0) as average_actual,
          round(avg(response.subitem_desirable),0) as average_desirable
        from
          response
        inner join
          subitem on response.subitem_id=subitem.subitem_id
        group by
          subitem.org_culture
        order by case org_culture
                      when 'Clan' then 1
                      when 'Adhocracy' then 2
                      when 'Market' then 3
                      when 'Hierarchy' then 4
                      else 5
                  end";

      $results["all"] = ORM::for_table('response')->raw_query($str)->find_array();

      $str="
        select
          item.item_id as item_id,
          item.label as dimensao,
          subitem.org_culture as org_culture,
          round(avg(response.subitem_actual),0) as average_actual,
          round(avg(response.subitem_desirable),0) as average_desirable
        from
          response
        inner join
          subitem on response.subitem_id=subitem.subitem_id
        inner join item on item.item_id=subitem.item_id
        group by
          item.item_id, subitem.org_culture
        order by item.item_id,
              case subitem.org_culture when 'Clan' then 1
                  when 'Adhocracy' then 2
                  when 'Market' then 3
                  when 'Hierarchy' then 4
                  else 5
              end;";

      $results["by_dimension"] = ORM::for_table('response')->raw_query($str)->find_array();

      return $results;
  }


?>

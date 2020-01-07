<?php 
/**
* Generates pagination
*
* @param array 
*
* @return void
*/ 
function pagination($constraints = '')
{ ?>
<nav aria-label="Page navigation example">
   <ul class="pagination">
      <?php for ($i = 1; $i <= $constraints['totalPages']; $i++) { ?>
      <li class="page-item <?php echo ($i == $constraints['pageNumber'])?'active':''; ?>">
         <a <?php if ($i != $constraints['pageNumber']) { ?>
            href="<?php echo $constraints['paginationLink'];?>?search=<?php echo $constraints['searchWord'];?>&page=<?php echo $i;?>&column=<?php echo $constraints['column'];?>&order=<?php echo $constraints['order'];?>" 
            <?php } ?>
            class="page-link"> 
         <?php  echo $i; ?>
         </a>
      </li>
      <?php } ?>
   </ul>
</nav>
<?php } ?>





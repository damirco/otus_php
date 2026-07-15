<?php
/**
 * Функция mergeTwoLists возвращает новый отсортированный список из двух других отсортированных списков.
 * Временная сложность алгоритма O(n + m), где n - длина первого списка, m - длина второго списка.
 * Пространственная сложность алгоритма O(1), т.к. изменяются только указатели на узлы
 * (новый узел создается лишь один раз в начале функции)
 */


class ListNode {
    public $val = 0;
    public $next = null;
    public function __construct($val = 0, $next = null) {
        $this->val = $val;
        $this->next = $next;
    }
}

class Solution {

    /**
     * @param ListNode $list1
     * @param ListNode $list2
     * @return ListNode
     */
    public function mergeTwoLists(?ListNode $list1, ?ListNode $list2) {
        $result = new ListNode();
        $current = $result;

        while ($list1 !== null && $list2 !== null) {
            if ($list1->val <= $list2->val) {
                $current->next = $list1;
                $list1 = $list1->next;
            } else {
                $current->next = $list2;
                $list2 = $list2->next;
            }
            $current = $current->next;
        }
        $current->next = ($list1 !== null) ? $list1 : $list2;

        return $result->next;
    }
}

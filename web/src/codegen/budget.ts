/**
 * 
 * 
 *
 * 
 * 
 *
 * NOTEInterface: ThisInterface class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen.git
 * DoInterface not edit the class manually.
 */
import { AccountInterface } from './account';
import { BudgetCategoryInterface } from './budgetCategory';


export interface BudgetInterface { 
    id?: number;
    title?: string;
    accounts?: Array<AccountInterface>;
    moneyCategories?: Array<BudgetCategoryInterface>;
}

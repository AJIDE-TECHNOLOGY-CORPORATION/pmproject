<?php

namespace App\Http\Controllers;

use App\Bank;
use App\Transfer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminBankController extends Controller
{
    /* Accounts index*/
    public function accountsIndex(Request $request)
    {
        /* if the url has get method */
        $accounts = Bank::latest()->paginate(15);
        return view('admin.bank.index-accounts', compact('accounts'));
    }

    /* Accounts creation*/
    public function createAccounts(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.bank.create-accounts');
        } else {
            /* if the url has post method */
            $accounts = new Bank();
            $accounts->user_id = Auth::user()->id;
            $accounts->name = $request->name;
            $accounts->bank_name = $request->bank_name;
            $accounts->bank_name = $request->bank_name;
            $accounts->account_number = $request->account_number;
            $accounts->balance = $request->balance;
            $accounts->bank_address = $request->bank_address;
            $accounts->save();
            return redirect('/admin/bank/accounts')->with('message', 'Account created Successfully.');
        }
    }

    /* destroy Accounts information*/
    public function destroyAccounts($id)
    {
        $notes = Bank::find($id);
        $notes->delete();
        return redirect()->back()->with('message', 'Account Destroyed Successfully');
    }
    /* Accounts updation */
    public function updateAccounts(Request $request, $id)
    {
        $accounts = Bank::find($id);
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.bank.create-accounts', compact('accounts'));
        } else {
            /* if the url has post method */
            $accounts->user_id = Auth::user()->id;
            $accounts->name = $request->name;
            $accounts->bank_name = $request->bank_name;
            $accounts->bank_name = $request->bank_name;
            $accounts->account_number = $request->account_number;
            $accounts->balance = $request->balance;
            $accounts->bank_address = $request->bank_address;
            $accounts->save();
            return redirect('/admin/bank/accounts')->with('message', 'Account Updated Successfully');
        }
    }

    /* Transfer index*/
    public function transferIndex(Request $request)
    {
        /* if the url has get method */
        $transfers = Transfer::latest()->paginate(15);
        return view('admin.transfer.index', compact('transfers'));
    }

    /* Accounts creation*/
    public function createTransfer(Request $request)
    {
        if ($request->isMethod('get')) {
            /* if the url has get method */
            return view('admin.transfer.create');
        } else {

            /* transfer amount verification and debit process */
            $from_account = Bank::find($request->from_id);
            if($from_account->balance < $request->amount) {
            /* if the debit amount greater than account holder's balance */
              return redirect()->back()->with('error', 'Transaction amount exceeds Account Balance.');
            }
            $from_account->balance =  $from_account->balance - $request->amount;
            $from_account->save();
 
            /* credit process */
            $to_account = Bank::find($request->to_id);
            $to_account->balance =  $to_account->balance + $request->amount;
            $to_account->save();

            /* if the url has post method */
            $transfer = new Transfer();
            $transfer->user_id = Auth::user()->id;
            $transfer->from_id = $request->from_id;
            $transfer->to_id = $request->to_id;
            $transfer->amount = $request->amount;
            $transfer->reference = $request->reference;
            $transfer->date = $request->date;
            $transfer->description = $request->description;
            $transfer->save();
            return redirect('/admin/bank/transfer')->with('message', 'Amount Transfered Successfully.');
        }
    }
      /* Edit Transfer*/
      public function updateTransfer(Request $request,$id)
      {
        $transfer = Transfer::find($id);
          if ($request->isMethod('get')) {
              /* if the url has get method */
              return view('admin.transfer.create',compact('transfer'));
          } else {
           
              /* if the url has post method */
              $transfer_old_amount = $transfer->amount;

              if($transfer_old_amount > $request->amount) {
                $amount_tobe_transerfered = $transfer_old_amount - $request->amount;
                 /* transfer amount verification and debit process */
                    $to_account = Bank::find($transfer->to_id);
                    if($to_account->balance <  $amount_tobe_transerfered) {
                    /* if the debit amount greater than account holder's balance */
                    return redirect()->back()->with('error', 'Transaction amount exceeds Account Balance.');
                    } 

                /* transfer amount verification and debit process */
                $from_account = Bank::find($request->from_id);
                $from_account->balance =  $from_account->balance + $amount_tobe_transerfered;
                $from_account->save();

                /* credit process */
                $to_account = Bank::find($request->to_id);
                $to_account->balance =  $to_account->balance - $amount_tobe_transerfered;
                $to_account->save();
                
              } else {
                $amount_tobe_transerfered = $request->amount - $transfer_old_amount;
         
                /* transfer amount verification and debit process */
                $from_account = Bank::find($request->from_id);
                if($from_account->balance < $amount_tobe_transerfered) {
                /* if the debit amount greater than account holder's balance */
                return redirect()->back()->with('error', 'Transaction amount exceeds Account Balance.');
                }
                $from_account->balance =  $from_account->balance - $amount_tobe_transerfered;
                $from_account->save();

                /* credit process */
                $to_account = Bank::find($request->to_id);
                $to_account->balance =  $to_account->balance + $amount_tobe_transerfered;
                $to_account->save();
              }
              $transfer->user_id = Auth::user()->id;
              $transfer->from_id = $request->from_id;
              $transfer->to_id = $request->to_id;
              $transfer->amount = $request->amount;
              $transfer->reference = $request->reference;
              $transfer->date = $request->date;
              $transfer->description = $request->description;
              $transfer->save();
              return redirect('/admin/bank/transfer')->with('message', 'Amount Transfer Updated Successfully.');
          }
      }
       /* destroy Accounts information*/
    public function destroyTransfer($id)
    {
        $transfer = Transfer::find($id);
        $transfer_amount = $transfer->amount;
            /* transfer amount verification and debit process */
            $to_account = Bank::find($transfer->to_id);
            if($to_account->balance < $transfer_amount) {
            /* if the debit amount greater than account holder's balance */
            return redirect()->back()->with('error', 'Transaction amount exceeds Account Balance.');
            }
            $to_account->balance =  $to_account->balance - $transfer_amount;
            $to_account->save();

            /* credit process */
            $from_account = Bank::find($transfer->from_id);
            $from_account->balance =  $from_account->balance + $transfer_amount;
            $from_account->save();
        $transfer->delete();
        return redirect()->back()->with('message', 'Amount Transfer Cancelled Successfully.');
    }
}
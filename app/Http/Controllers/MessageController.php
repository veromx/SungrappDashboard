<?php

namespace Sungrapp\Http\Controllers;

use Sungrapp\Models\Message;
use Sungrapp\Models\Supplier;
use Illuminate\Http\Request;
use Sungrapp\Http\Requests\StoreSupplierRequest;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
		$suppliers = Supplier::with('messages')
			->potentialSuppliers()
			->get();
		$messages = Message::all()->toArray();
        return view('messages.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('partials.contact_form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupplierRequest $request)
    {
        $supplier_controller = new SupplierController();
		$supplier = $supplier_controller->store($request);

		$message = Message::create(['supplier_id'=>$supplier->id, 'message'=>$request->message]);

		// store supplier name and content into an array
		$message_email['supplier'] = $message->supplier->full_name;
		$message_email['content'] = $message->message;
		$message_email['sender'] = $request->email;

		// TODO: Send email
		Mail::send('partials.contact_message', $message_email, function($email){
			// config/mail.php
			// $email->from($mailer_address);
			// $email->to('admin@example.com');
			$email->subject('Nuevo mensaje de Landing Page');
		});
		return $message;
    }

    /**
     * Display the specified resource.
     *
     * @param  \Sungrapp\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \Sungrapp\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function edit(Message $message)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Sungrapp\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Sungrapp\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}

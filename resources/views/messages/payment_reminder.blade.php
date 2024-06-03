Olá, {{ $clientName }}!

Esperamos que você esteja bem. Notamos que há algumas contas pendentes em seu nome e gostaríamos de lembrá-lo gentilmente para efetuar o pagamento o mais rápido possível.

Detalhes das contas vencidas:

@foreach ($overdueAccounts as $account)
Conta do dia {{ $account->created_at->format('d/m/Y') }}:
- Valor Total: {{ number_format($account->total_amount, 0, ',', '.') }} G$
- Valor Pago: {{ number_format($account->amount_paid, 0, ',', '.') }} G$
- Data de Vencimento: {{ $account->due_date->format('d/m/Y') }}

@endforeach

Resumo das Contas Vencidas:
- Valor Total: {{ $totalAmount }}
- Valor Pago: {{ $amountPaid }}
- Valor Restante: {{ $remainingAmount }}

Agradecemos por sua atenção e por continuar escolhendo a Casa de Carnes B2. Estamos à disposição para qualquer dúvida ou assistência.

Tenha um ótimo dia!
Casa de Carnes B2

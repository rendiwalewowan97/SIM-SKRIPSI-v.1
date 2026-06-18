@props(['value'])
@php $map=['diajukan'=>'bg-yellow-100 text-yellow-800','menunggu'=>'bg-yellow-100 text-yellow-800','disetujui'=>'bg-green-100 text-green-800','diverifikasi'=>'bg-blue-100 text-blue-800','dijadwalkan'=>'bg-indigo-100 text-indigo-800','selesai'=>'bg-green-100 text-green-800','ditolak'=>'bg-red-100 text-red-800','revisi'=>'bg-orange-100 text-orange-800','direview'=>'bg-blue-100 text-blue-800']; @endphp
<span class="rounded px-2 py-1 text-xs font-semibold {{ $map[$value] ?? 'bg-slate-100 text-slate-700' }}">{{ strtoupper(str_replace('_',' ', $value)) }}</span>
